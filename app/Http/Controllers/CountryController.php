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
                ->make(true);        }

        return view('countries.index');
    }

    public function getCountries(Request $request)
{
    $search = $request->input('q'); // 'q' adalah parameter pencarian dari Select2
    $countries = Country::where('name', 'like', '%' . $search . '%')->get();
    
    $results = $countries->map(function($country) {
        return [
            'id' => $country->id,
            'text' => $country->name,
            'code' => $country->code,
        ];
    });
    
    return response()->json($results);
}
}
