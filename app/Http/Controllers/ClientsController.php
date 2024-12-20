<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Consignee;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\ClientCompany;
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



    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Clients::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $client = Clients::findOrFail($id);
        $client->update($request->all());

        return redirect($request->input('previous_url', route('clients.index')))
            ->with('success', 'Data berhasil diperbarui.');
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
        $client = Clients::with('company')->find($clientId);
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
        $query = ClientCompany::query();

        if (!empty($search)) {
            $query->where('company_name', 'like', '%' . $search . '%');
        }

        $clientCompanies = $query->select('id', 'company_name') // Ambil ID dan Nama Perusahaan
            ->orderBy('company_name', 'asc')
            ->paginate(10);

        return response()->json([
            'results' => $clientCompanies->map(function ($company) {
                return [
                    'id' => $company->id, // ID sebagai value
                    'text' => $company->company_name // Nama perusahaan sebagai teks
                ];
            }),
            'pagination' => ['more' => $clientCompanies->hasMorePages()]
        ]);
    }
}
