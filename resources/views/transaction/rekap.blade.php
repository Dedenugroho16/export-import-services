@extends('layouts.layout')
@section('title', 'Rekap Sales')

@section('content')
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
                <th>Freight Cost</th>
                <th>Price Amount</th>
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
                        <td>{{ $transaction->freight_cost }}</td>
                        <td>{{ $detail->price_amount }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ $transaction->total }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
  </div>
@endsection