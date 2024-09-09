<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel 'countries'
        $countries = Country::all();

        // Mengirim data ke view
        return view('countries.index', compact('countries'));
    }
}
