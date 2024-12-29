<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Imports\CountriesImport;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Country::all();

            return DataTables::of($countries)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $editUrl = route('countries.edit', $hashId);

                    return '<a href="' . $editUrl . '" class="btn btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                    Edit
                    </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('countries.index');
    }


    public function getCountries(Request $request)
    {
        $search = $request->input('q'); // 'q' is the search parameter from Select2
        $countries = Country::where('name', 'like', '%' . $search . '%')->get();

        $results = $countries->map(function ($country) {
            return [
                'id' => $country->id,
                'text' => $country->name,
                'code' => $country->code, // Include country code here
            ];
        });

        return response()->json($results);
    }

    public function import()
    {
        return view('countries.import');
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
            $import = new CountriesImport();
            Excel::import($import, $request->file('file'));

            $results = $import->getResults();

            return redirect()->route('countries.index')
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
        return view('countries.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);
        Country::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('countries.index')->with('success_store', 'Data berhasil ditambahkan.');
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $country = Country::findOrFail($id);
        return view('countries.edit', compact('country'));
    }

    // Method to update a specific commodity
    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|max:255',
            'code' => 'required',
        ]);

        $country = Country::findOrFail($id);
        $country->update($request->all());

        return redirect()->route('countries.index')->with('success_store', 'Data berhasil diperbarui.');
    }
}
