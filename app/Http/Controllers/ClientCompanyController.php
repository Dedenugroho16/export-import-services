<?php

namespace App\Http\Controllers;

use App\Helpers\IdHashHelper;
use App\Models\ClientCompany;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClientCompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $client_company = ClientCompany::select('id', 'company_name');
            return DataTables::of($client_company)
            ->addColumn('action', function ($row) {
                $hashId = IdHashHelper::encode($row->id);
            
                // Mulai dengan tombol Tampilkan
                $actionBtns = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route('client-companies.show', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Tampilkan
                            </a>';
            
                // Pengecekan akses untuk role admin dan operator
                if (in_array(auth()->user()->role, ['admin', 'operator'])) {
                    $actionBtns .= '
                        <a class="dropdown-item" href="' . route('client-companies.edit', $hashId) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(\'' . route('client-companies.destroy', $hashId) . '\')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            Hapus
                        </a>';
                }
            
                // Tutup dropdown
                $actionBtns .= '
                        </div>
                    </div>';
            
                return $actionBtns;
            })
            ->rawColumns(['action'])
            ->make(true);
            
        }

        return view('client-company.index');
    }

 
    public function create()
    {
        return view('client-company.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
        ]);

        ClientCompany::create($request->all());
        return redirect()->route('client-companies.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client_company = ClientCompany::findOrFail($id);
        return view('client-company.show', compact('client_company'));
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
        ]);

        $client_company = ClientCompany::findOrFail($id);
        $client_company->update($request->all());

        return redirect($request->input('previous_url', route('client-companies.index')))
        ->with('success', 'Data berhasil diperbarui.');
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
