<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use Yajra\DataTables\DataTables;
use App\Imports\CommoditiesImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CommoditiesController extends Controller
{
    // Method to display the commodities list using DataTables
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $commodities = Commodity::select('id', 'name');
            return DataTables::of($commodities)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $userRole = auth()->user()->role; // Get the current user's role
                    $actionBtn = '
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="' . route('commodities.show', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M17 7l-10 10" />
                                        <path d="M8 7l9 0l0 9" />
                                    </svg>
                                    Tampilkan
                                </a>';

                    // Add Edit and Delete actions only if the user is admin or operator
                    if (in_array($userRole, ['admin', 'operator'])) {
                        $actionBtn .= '
                            <a class="dropdown-item" href="' . route('commodities.edit', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                            </a>';
                    }

                    $actionBtn .= '
                            </div>
                        </div>';

                    return $actionBtn;
                })
                ->rawColumns(['action']) // Allows HTML in 'action' column
                ->make(true);
        }


        return view('commodities.index');
    }

    public function import()
    {
        return view('commodities.import');
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
            $import = new CommoditiesImport();
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            return redirect()->route('commodities.index')
                ->with('success', $results['success'])
                ->with('exists', $results['exists'])
                ->with('failed', $results['failed']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method to return the create form view
    public function create()
    {
        return view('commodities.create');
    }

    // Method to store a newly created commodity in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Commodity::create($request->all());
        return redirect()->route('commodities.index')->with('success_store', 'Data berhasil ditambahkan.');
    }

    // Method to show details of a specific commodity
    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        return view('commodities.show', compact('commodity'));
    }

    // Method to return the edit form for a specific commodity
    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        return view('commodities.edit', compact('commodity'));
    }

    // Method to update a specific commodity
    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $commodity = Commodity::findOrFail($id);
        $commodity->update($request->all());

        return redirect($request->input('previous_url', route('commodities.index')))
            ->with('success_store', 'Data berhasil diperbarui.');
    }

    // Method to delete a specific commodity
    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        $commodity->delete();

        return redirect()->route('commodities.index')->with('success', 'Data berhasil dihapus.');
    }

    public function getCommodities(Request $request)
    {
        $search = $request->input('q'); // 'q' adalah parameter pencarian dari Select2
        $commodities = Commodity::where('name', 'like', '%' . $search . '%')->get();

        $results = $commodities->map(function ($commodity) {
            return [
                'id' => $commodity->id,
                'text' => $commodity->name,
            ];
        });

        return response()->json($results);
    }
}