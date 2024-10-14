<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Country;
use App\Models\User;
use App\Models\Branch;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();
        $productsCount = Product::count();
        $commoditiesCount = Commodity::count();
        $countriesCount = Country::count();
        $usersCount = User::count();
        $branchesCount = Branch::count();
        $transactionsCount = Transaction::count();

        return view('dashboard.index', compact(
            'clientsCount', 
            'productsCount', 
            'commoditiesCount', 
            'countriesCount', 
            'usersCount', 
            'branchesCount', 
            'transactionsCount'
        ));
    }
}
