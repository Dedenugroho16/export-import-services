<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Consignee;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\ClientCompany;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $client = Clients::query();
            return DataTables::of($client)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $userRole = auth()->user()->role;
                    $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                        Aksi
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="' . route('clients.details', $hashId) . '" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user me-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            Lihat Consignee
                        </a>
                        <a class="dropdown-item" href="' . route('clients.show', $hashId) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M17 7l-10 10" />
                                <path d="M8 7l9 0l0 9" />
                            </svg>
                            Tampilkan
                        </a>';

                    if (in_array($userRole, ['admin', 'operator'])) {
                        $actionBtn .= '
                        <a class="dropdown-item" href="' . route('clients.edit', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </a>';
                    }

                    $actionBtn .= '
                    </div>
                </div>';

                    return $actionBtn;
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company->company_name ?? 'N/A';
                })
                ->addColumn('company_id', function ($row) {
                    return $row->company->id ?? '';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('clients.index');
    }

    public function import()
    {
        return view('clients.import');
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.mimes' => 'File harus berupa Excel dengan format xlsx atau xls.',
        ]);

        try {
            $import = new ClientsImport();
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            return redirect()->route('clients.index')
                ->with('success', $results['success'])
                ->with('failed', $results['failed'])
                ->with('exists', $results['exists']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'client_companies' => 'required|array',
            'client_companies.*' => 'exists:client_company,id',
        ]);

        $client = Clients::create([
            'name' => $validatedData['name'],
        ]);

        // Simpan relasi dengan client_company di tabel pivot
        $client->clientCompanies()->sync($validatedData['client_companies']);

        return redirect()->route('clients.index')->with('success_store', 'Data client berhasil ditambahkan.');
    }


    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function edit($id)
    {
        $clientId = IdHashHelper::decode($id);

        // Ambil data client beserta perusahaan yang terkait
        $client = Clients::with('clientCompanies')->findOrFail($clientId);

        // Ambil ID dan nama perusahaan yang sudah terhubung dengan client
        $selectedCompanies = $client->clientCompanies->map(function ($company) {
            return [
                'id' => $company->id,
                'text' => $company->company_name,
            ];
        });

        return view('clients.edit', compact('client', 'selectedCompanies'));
    }


    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|string|max:255',
            'client_companies' => 'required|array',
            'client_companies.*' => 'exists:client_company,id',
        ]);

        $client = Clients::findOrFail($id);

        $client->update([
            'name' => $request->input('name'),
        ]);

        // Sinkronisasi perusahaan di tabel pivot
        $client->clientCompanies()->sync($request->input('client_companies'));

        return redirect($request->input('previous_url', route('clients.index')))
            ->with('success_store', 'Data berhasil diperbarui.');
    }

    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Data berhasil dihapus.');
    }

    public function details(Request $request, $hash)
    {
        // Decode hash menjadi client_id
        $clientId = IdHashHelper::decode($hash);
        $client = Clients::with('clientCompanies')->find($clientId);
        $client = Clients::findOrFail($clientId);

        if ($request->ajax()) {
            $consignee = Consignee::where('id_client', $clientId);

            return DataTables::of($consignee)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $userRole = auth()->user()->role;

                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route('consignees.show', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Tampilkan
                            </a>';


                    if (in_array($userRole, ['admin', 'operator'])) {
                        $actionBtn .= '
                            <a class="dropdown-item" href="' . route('consignees.edit', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                            </a>';
                    }

                    $actionBtn .= '
                        </div>
                    </div>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('clients.details', compact('client', 'hash'));
    }

    public function getClientCompanies(Request $request)
    {
        $search = $request->input('search');

        // Query untuk filter data berdasarkan client_company_name
        $query = ClientCompany::query()
            ->select('id', 'company_name') // Ambil hanya kolom yang diperlukan
            ->orderBy('company_name', 'asc');

        if (!empty($search)) {
            $query->where('company_name', 'like', '%' . $search . '%');
        }

        $clientCompanies = $query->get();

        return response()->json([
            'results' => $clientCompanies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'text' => $company->company_name, // Key 'text' sesuai kebutuhan Select2
                ];
            })
        ]);
    }
}
