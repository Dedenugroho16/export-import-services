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
                    <th class="text-center">Ocean Freight</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
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
                        <tr>
                            <td style="text-align: center">{{ $key + 1 }}</td>
                            <td>{{ $transaction->stuffing_date }}</td>
                            <td>{{ $transaction->code }}</td>
                            <td>{{ $transaction->number }}</td>
                            <td>{{ $transaction->bl_number }}</td>
                            <td>{{ $transaction->container_number }}</td>
                            <td>{{ $transaction->seal_number }}</td>
                            <td class="text-center">{{ formatCurrency($transaction->net_weight) }}</td>
                            <td class="text-center">{{ formatCurrency($transaction->gross_weight) }}</td>
                            <td class="text-center">{{ formatCurrency($transaction->freight_cost) }}</td>
                            <td class="text-center">{{ formatCurrency($transaction->total_price_amount) }}</td>
                            <td class="text-center">{{ formatCurrency($transaction->total) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total</th>
                    <th>{{ $totalNetWeight }}</th>
                    <th>{{ $totalGrossWeight }}</th>
                    <th>{{ $totalFreightCost }}</th>
                    <th>{{ $totalAmount }}</th>
                    <th>{{ $total }}</th>
                </tr>
            </tfoot>
        </table>
    </div>    
</body>
</html>