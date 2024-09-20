<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Country::all();
            return DataTables::of($countries)
                ->make(true);
        }

        return view('countries.index');
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

        Country::create($request->only(['name', 'code']));
        
        return redirect()->route('countries.index')->with('success', 'Country added successfully.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);

        $country = Country::findOrFail($id);
        $country->update($request->only(['name', 'code']));

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Negara berhasil di hapus.');
    }
}
