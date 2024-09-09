<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsigneesController extends Controller
{
    public function index()
    {
        return view('consignees.index');
    }

}
