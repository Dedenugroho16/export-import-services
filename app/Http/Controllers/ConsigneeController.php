<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsigneeController extends Controller
{
    public function index()
    {
        return view('consignee');
    }
}
