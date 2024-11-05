<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Sales</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #a3a3a3; padding: 8px; }
        th { background-color: #36c1eb; }
        h1 { text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div style="text-align: center">
        <h3 style="margin: 0;">PT. PRINGGONDANI SETIA NUSANTARA<br>REKAP SALES</h3>
        <p style="font-size: 15px; margin: 0;">
            PERIODE STUFFING : {{ $startDate }} s/d {{ $endDate }}
        </p>
    </div>  

    <div class="table-rekap">
        <table style="border: 1px solid">
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
                    <th class="text-center">Kurs</th>
                    <th class="text-center">Ocean Freight</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalNetWeight = 0;
                    $totalGrossWeight = 0;
                    $totalFreightCost = 0;
                    $totalAmount = 0;
                    $totalOverall = 0;
                @endphp

                @if($filterApplied && $transactions->isEmpty())
                    <tr>
                        <td colspan="13" class="text-center">Tidak ada transaksi untuk periode yang dipilih.</td>
                    </tr>
                @elseif(!$filterApplied)
                    <tr>
                        <td colspan="13" class="text-center">Silakan lakukan filter berdasarkan stuffing date.</td>
                    </tr>
                @else
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

                            @php
                                $totalNetWeight += $transaction->net_weight;
                                $totalFreightCost += $transaction->freight_cost;
                                $totalAmount += $detail->price_amount;
                                $totalOverall += $transaction->total;
                            @endphp
                        @endforeach
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total</th>
                    <th>{{ $totalNetWeight }}</th>
                    <th></th>
                    <th></th>
                    <th>{{ $totalFreightCost }}</th>
                    <th>{{ $totalAmount }}</th>
                    <th>{{ $totalOverall }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>