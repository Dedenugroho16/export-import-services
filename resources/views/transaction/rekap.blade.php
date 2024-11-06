@extends('layouts.layout')
@section('title', 'Rekap Sales')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 mt-4 d-flex justify-content-between">
            <!-- Filter by Date -->
            <div class="d-flex justify-content-between align-items-center">
                <form class="d-flex align-items-center" method="GET" action="{{ route('transactions.rekap') }}">
                    <div class="input-group">
                        <input type="date" class="form-control" name="start_date" aria-label="Tanggal Awal" value="{{ request('start_date') }}" required>
                        <input type="date" class="form-control" name="end_date" aria-label="Tanggal Akhir" value="{{ request('end_date') }}" required>
                        <button type="submit" class="btn btn-primary d-flex align-items-center">
                            Filter
                        </button>
                        <a href="{{ route('transactions.rekap') }}" class="btn btn-danger me-2">Reset</a>
                    </div>
                </form>
            </div>
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                </svg>
                Ekspor/Download
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('rekap.sales.exportPdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" target="_blank">
                        Ekspor PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('rekap.sales.downloadPdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">
                        Download PDF
                    </a>
                </li>
            </ul>
        </div>        

        <!-- Rekap Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Company Name -->
                        <div class="text-center mb-5" style="font-family: 'Times New Roman', Times, serif">
                            <h2 class="mb-1"><strong>PT.PRINGGONDANI SETIA NUSANTARA<br>REKAP SALES</strong></h2>
                            <p style="font-size: 15px">
                                PERIODE STUFFING 
                                {{ request('start_date') ? request('start_date') : '-' }} 
                                s/d 
                                {{ request('end_date') ? request('end_date') : '-' }}
                            </p>
                        </div>
                        
                        <!-- Table Starts Here -->
                        <div id="rekapTable" class="table-responsive">
                            <table class="table table-vcenter table-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Stuffing Date</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Invoice Number</th>
                                        <th class="text-center">BL Number</th>
                                        <th class="text-center">Container Number</th>
                                        <th class="text-center">Seal Number</th>
                                        <th class="text-center">Net Weight</th>
                                        <th class="text-center">Gross Weight</th>
                                        <th class="text-center">Ocean Freight</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                    @if($filterApplied && $transactions->isEmpty())
                                        <tr>
                                            <td colspan="13" class="text-center">Tidak ada transaksi untuk periode yang dipilih.</td>
                                        </tr>
                                    @elseif(!$filterApplied)
                                        <tr>
                                            <td colspan="13" class="text-center">Silakan lakukan filter berdasarkan stuffing date.</td>
                                        </tr>
                                    @else
                                    <tbody>
                                        @foreach($transactions as $key => $transaction)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $transaction->stuffing_date }}</td>
                                                <td class="text-center">{{ $transaction->code }}</td>
                                                <td class="text-center">{{ $transaction->number }}</td>
                                                <td class="text-center">{{ $transaction->bl_number }}</td>
                                                <td class="text-center">{{ $transaction->container_number }}</td>
                                                <td class="text-center">{{ $transaction->seal_number }}</td>
                                                <td class="text-center">{{ formatCurrency($transaction->net_weight) }}</td>
                                                <td class="text-center">{{ formatCurrency($transaction->gross_weight) }}</td>
                                                <td class="text-center">{{ formatCurrency($transaction->freight_cost) }}</td>
                                                <td class="text-center">{{ formatCurrency($transaction->total_price_amount) }}</td>
                                                <td class="text-center">{{ formatCurrency($transaction->total) }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center" colspan="7">Total</th>
                                        <th class="text-center">{{ $totalNetweight }}</th>
                                        <th class="text-center">{{ $totalGrossweight }}</th>
                                        <th class="text-center">{{ $totalFreightcost }}</th>
                                        <th class="text-center">{{ $totalAmount }}</th>
                                        <th class="text-center">{{ $total }}</th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>                        
                        <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection