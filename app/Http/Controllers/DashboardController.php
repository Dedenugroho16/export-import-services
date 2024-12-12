<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\BillOfPayment;
use App\Models\Client;
use App\Models\ClientCompany;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Country;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Company;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $commoditiesCount = Commodity::count();
        $countriesCount = Country::count();
        $usersCount = User::count();
        $transactionsCount = Transaction::count();
        $companyCount = Company::count();
        $transactions = Transaction::all();
        $totalSales = $transactions->sum('total_price');
        $waitingApprove = Transaction::where('approved', 0)->count();
        $ApproveProforma = Transaction::where('approved',1)->count();
        $unconfirmedInvoice = Transaction::where('approved', 1)->whereNull('stuffing_date')->count();
        $finalInvoice = Transaction::whereNotNull('stuffing_date')->count();
        $paymentDetail = PaymentDetail::count();

        $userName = Auth::user()->name;
        $clientsCount = Client::count();
        $productsCount = Product::count();
        $packingListCount = Transaction::whereNotNull('stuffing_date')->count();
        $sumTotalPayment = PaymentDetail::sum('total');
        $totalBOP = BillOfPayment::sum('total');
        $sumTotalBop = BillOfPayment::sum('total');
        $totalFinalInvoice = Transaction::whereDate('updated_at', Carbon::today())->whereNotNull('stuffing_date')->sum('total');
        $bopCount = BillOfPayment::count();
        $lunasCount = BillOfPayment::where('status', 1)->count();
        $belumLunasCount = BillOfPayment::where('status', 0)->count();
        $totalLunas = BillOfPayment::where('status', 1)->sum('total');
        $totalBelumLunas = BillOfPayment::where('status', 0)->sum('total');
        $clientCompany = ClientCompany::count();


        return view('dashboard.index', compact(
            'clientsCount',
            'totalFinalInvoice', 
            'productsCount', 
            'commoditiesCount', 
            'countriesCount', 
            'usersCount',
            'transactionsCount',
            'companyCount',
            'totalSales',
            'waitingApprove',
            'ApproveProforma',
            'unconfirmedInvoice',
            'finalInvoice',
            'lunasCount',
            'belumLunasCount',
            'bopCount',
            'totalBOP',
            'paymentDetail',
            'packingListCount',
            'totalLunas',
            'totalBelumLunas',
            'clientCompany',
            'sumTotalBop',
            'sumTotalPayment',
        ))->with('title', "Hallo, $userName");
    }

    public function getInvoiceData()
    {
        $invoiceData = DB::table('transactions')
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(total) as total'))
            ->whereBetween('updated_at', [now()->subMonth(), now()])
            ->whereNotNull('stuffing_date')
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->get();

        return response()->json($invoiceData);
    }
}
