<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Helpers\IdHashHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
                    return '
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="' . route('commodities.show', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                    Tampilkan
                                </a>
                                <a class="dropdown-item" href="' . route('commodities.edit', $hashId) . '">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                     Edit
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(\'' . route('commodities.destroy', $hashId) . '\')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    Hapus
                                </a>
                            </div>
                        </div>';
                })
                ->rawColumns(['action']) // Allows HTML in 'action' column
                ->make(true);
        }

        return view('commodities.index');
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
        return redirect()->route('commodities.index')->with('success', 'Data berhasil ditambahkan.');
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
        ->with('success', 'Data berhasil diperbarui.');
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