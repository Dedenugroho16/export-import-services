<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

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

    public function show(Commodity $commodity)
    {
        return view('commodities.show', compact('commodity'));
    }

    public function edit(Commodity $commodity)
    {
        return view('commodities.edit', compact('commodity'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $commodity->update($request->all());
        return redirect()->route('commodities.index')->with('success', 'Commodity updated successfully.');
    }

    public function destroy(Commodity $commodity)
    {
        $commodity->delete();
        return redirect()->route('commodities.index')->with('error', 'Commodity deleted successfully.');
    }
}
