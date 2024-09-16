<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Helpers\IdHashHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommoditiesController extends Controller
{
    public function index()
    {
        $commodities = Commodity::all();
        return view('commodities.index', compact('commodities'));
    }

    public function create()
    {
        return view('commodities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Commodity::create($request->all());
        return redirect()->route('commodities.index')->with('success', 'Commodity created successfully.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        return view('commodities.show', compact('commodity'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        return view('commodities.edit', compact('commodity'));
    }

    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $commodity = Commodity::findOrFail($id);
        $commodity->update($request->all());

        return redirect()->route('commodities.index')->with('success', 'Commodity updated successfully.');
    }

    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $commodity = Commodity::findOrFail($id);
        $commodity->delete();


        return redirect()->route('commodities.index')->with('success', 'Commodity deleted successfully.');
    }
}
