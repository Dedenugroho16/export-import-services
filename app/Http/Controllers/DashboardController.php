<?php

namespace App\Http\Controllers;

use App\Models\BillOfPayment;
use App\Models\Client;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Country;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();
        $productsCount = Product::count();
        $commoditiesCount = Commodity::count();
        $countriesCount = Country::count();
        $usersCount = User::count();
        $transactionsCount = Transaction::count();
        $companyCount = Company::count();
        $transactions = Transaction::all();
        $totalSales = $transactions->sum('total_price');
        $billsCount = Transaction::count();
        $waitingApprove = Transaction::where('approved', 0)->count();
        $ApproveProforma = Transaction::where('approved',1)->count();
        $ApproveProforma = Transaction::where('approved',1)->count();
        $unconfirmedInvoice = Transaction::whereNull('stuffing_date')->count();
        $finalInvoice = Transaction::whereNotNull('stuffing_date')->count();
        $lunasCount = BillOfPayment::where('status', 1)->count();
        $belumLunasCount = BillOfPayment::where('status', 0)->count();
        $bopCount = BillOfPayment::count();



        return view('dashboard.index', compact(
            'clientsCount', 
            'productsCount', 
            'commoditiesCount', 
            'countriesCount', 
            'usersCount',
            'transactionsCount',
            'companyCount',
            'totalSales',
            'billsCount',
            'waitingApprove',
            'ApproveProforma',
            'unconfirmedInvoice',
            'finalInvoice',
            'lunasCount',
            'belumLunasCount',
            'bopCount',
        ));
    }
}
