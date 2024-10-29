@extends('layouts.layout')
@section('title', 'Rekap Sales')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Filter by Date -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <form class="d-flex align-items-center" method="GET" action="{{ route('transactions.rekap') }}">
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date" aria-label="Tanggal Awal" required>
                    <input type="date" class="form-control" name="end_date" aria-label="Tanggal Akhir" required>
                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                        Filter
                    </button>
                </div>
            </form>
        </div>
        <!-- Rekap Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Table Starts Here -->
                        <div class="table-responsive">
                            <table
                                  class="table table-vcenter table-nowrap">
                                  <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Stuffing Date</th>
                                        <th>Code</th>
                                        <th>Invoice Number</th>
                                        <th>BL Number</th>
                                        <th>Container Number</th>
                                        <th>Seal Number</th>
                                        <th>Net Weight</th>
                                        <th>Gross Weight</th>
                                        <th>Kurs</th>
                                        <th>Ocean Freight</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $key => $transaction)
                                        @foreach($transaction->detailTransactions as $detail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transaction->stuffing_date }}</td>
                                                <td>{{ $transaction->code }}</td>
                                                <td>{{ $transaction->number }}</td>
                                                <td>{{ $transaction->bl_number }}</td>
                                                <td>{{ $transaction->container_number }}</td>
                                                <td>{{ $transaction->seal_number }}</td>
                                                <td>{{ $transaction->net_weight }}</td>
                                                <td>{{ $transaction->gross_weight }}</td>
                                                <td>14,00</td>
                                                <td>{{ $transaction->freight_cost }}</td>
                                                <td>{{ $detail->price_amount }}</td>
                                                <td>{{ $transaction->total }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
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