<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\ClientCompany;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientCompaniesImport;
use Yajra\DataTables\Facades\DataTables;

class ClientCompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $client_company = ClientCompany::query();
            return DataTables::of($client_company)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $userRole = auth()->user()->role;

                    // Jika pengguna adalah admin atau operator
                    if (in_array($userRole, ['admin', 'operator'])) {
                        $actionBtns = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route('client-companies.show', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Tampilkan
                            </a>
                            <a class="dropdown-item" href="' . route('client-companies.edit', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                            </a>
                        </div>
                    </div>';
                    } else {
                        // Jika pengguna bukan admin atau operator
                        $actionBtns = '
                    <a href="' . route('client-companies.show', $hashId) . '" class="btn btn-success">
                        Lihat
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right ms-1" style="margin: 0;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                    </a>';
                    }

                    return $actionBtns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('client-company.index');
    }


    public function import()
    {
        return view('client-company.import');
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
            $import = new ClientCompaniesImport();
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            return redirect()->route('client-companies.index')
                ->with('success', $results['success'])
                ->with('exists', $results['exists'])
                ->with('failed', $results['failed']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('client-company.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'address' => 'required|string',
            'PO_BOX' => 'nullable|string',
            'tel' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        ClientCompany::create($request->all());
        return redirect()->route('client-companies.index')->with('success_store', 'Data berhasil ditambahkan.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);

        // Ambil data client_company berdasarkan ID
        $client_company = ClientCompany::findOrFail($id);

        // Ambil semua client yang terhubung dengan client_company ini
        $clients = $client_company->clients;

        return view('client-company.show', compact('client_company', 'clients'));
    }

    public function edit(string $hash)
    {
        $id = IdHashHelper::decode($hash);
        $client_company = ClientCompany::findOrFail($id);
        return view('client-company.edit', compact('client_company'));
    }


    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'company_name' => 'required|max:255',
            'address' => 'required|string',
            'PO_BOX' => 'nullable|string',
            'tel' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        $client_company = ClientCompany::findOrFail($id);
        $client_company->update($request->all());

        return redirect($request->input('previous_url', route('client-companies.index')))
            ->with('success_store', 'Data berhasil diperbarui.');
    }


    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client_company = ClientCompany::findOrFail($id);
        $client_company->delete();

        return redirect()->route('client-companies.index')->with('success', 'Data berhasil dihapus.');
    }

    public function ajaxCompanies(Request $request)
    {
        $search = $request->get('q');  // Mendapatkan query pencarian
        $companies = ClientCompany::where('company_name', 'like', '%' . $search . '%')
            ->get(['id', 'company_name']);  // Mengambil kolom id dan company_name

        // Mengembalikan data dalam format JSON
        return response()->json($companies);
    }
}
