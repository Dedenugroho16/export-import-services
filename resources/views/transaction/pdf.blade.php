<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body{
        font-size: 14px;
    }
    .section-satu {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10mm;
    }

    .section-dua {
        width: 100%;
        margin-top: 10mm;
    }

    .section-tiga {
        width: 100%;
        margin-top: 10mm;
        text-align: center;
        font-size: 17px;
    }

    .section-empat {
        width: 100%;
        margin-top: 10mm;
    }

    .section-empat th {
        text-align: left;
    }

    .custom-table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 10mm;
    }

    .custom-table th, .custom-table td {
        border: 1px solid black;
        padding: 5px;
    }
    .custom-table tfoot td {
        font-weight: bold;
    }
    
    .custom-bg-red {
        background-color: rgb(65, 65, 197);
        color: white;
        text-align: center;
    }

    .approve-section {
        width: auto;
        font-size: 15px;
        text-align: center;
        float: right;
        margin-top: 10mm;
    }
</style>
<body>
    <table class="section-satu">
        <tr>
            <td>
                <table>
                    <tr>
                        <td><img src="{{ $logo }}" alt="Company Logo" style="width: 50px;"></td>
                        <td><em style="font-size: 60px; font-weight: bold;">PT.PSN</em>
                            <br>PRINGGONDANI SETIA NUSANTARA
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100%; font-size: 12px;">
                    <tr>
                        <td>Date</td>
                        <td>:</td>
                        <td style="text-align: right">{{ $transaction->date }}</td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td>:</td>
                        <td style="text-align: right">{{ $transaction->code }}</td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>:</td>
                        <td style="text-align: right">{{ $transaction->number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h2 style="text-align: center">INVOICE</h2>

    <table class="section-dua">
            <tr>
                <td style="width: 33%; font-weight: bold; font-size: 15px">CONSIGNEE</td>
                <td style="width: 33%; font-weight: bold; font-size: 15px">NOTIFY</td>
                <td style="width: 33%; font-weight: bold; font-size: 15px">CLIENT</td>
            </tr>
            <tr>
                <td style="font-weight: 300">{{ $transaction->consignee->name }}</td>
                <td style="font-weight: 300">{{ $transaction->notify }}</td>
                <td style="font-weight: 300">{{ $transaction->client->name }}</td>
            </tr>
            <tr>
                <td>{{ $transaction->consignee->address }}</td>
                <td></td>
                <td>{{ $transaction->client->address }}</td>
            </tr>
            <tr>
                <td>{{ $transaction->consignee->tel }}</td>
                <td></td>
                <td>{{ $transaction->client->tel }}</td>
            </tr>
    </table>

    <table class="section-tiga">
        <tr>
            <td style="font-weight: bold">Port of loading</td>
            <td style="font-weight: bold">Place of receipt</td>
            <td style="font-weight: bold">Port of discharge</td>
            <td style="font-weight: bold">Place of delivery</td>
        </tr>
        <tr>
            <td>{{ $transaction->port_of_loading }}</td>
            <td>{{ $transaction->place_of_receipt }}</td>
            <td>{{ $transaction->port_of_discharge}}</td>
            <td>{{ $transaction->place_of_delivery }}</td>
        </tr>
    </table>

    <table class="section-empat">
        <tr>
            <th style="width: 25%">Name of Product</th>
            <td style="width: 2%;">:</td>
            <td style="width: 40%">{{ $transaction->product->name }}</td>
            <th>Stuffing Date</th>
            <td style="width: 2%;">:</td>
            <td>{{ $transaction->stuffing_date }}</td>
        </tr>
        <tr>
            <th>Name of Commodity</th>
            <td>:</td>
            <td>{{ $transaction->commodity->name }}</td>
            <th>BL Number</th>
            <td>:</td>
            <td>{{ $transaction->bl_number }}</td>
        </tr>
        <tr>
            <th>Container</th>
            <td>:</td>
            <td>{{ $transaction->container }}</td>
            <th>Container Number</th>
            <td>:</td>
            <td>{{ $transaction->container_number }}</td>
        </tr>
        <tr>
            <th>Net Weight</th>
            <td>:</td>
            <td>{{ $transaction->net_weight }}</td>
            <th>Seal Number</th>
            <td>:</td>
            <td>{{ $transaction->seal_number }}</td>
        </tr>
        <tr>
            <th>Gross Weight</th>
            <td>:</td>
            <td>{{ $transaction->gross_weight }}</td>
            <th>Product NCM</th>
            <td>:</td>
            <td>{{ $transaction->product_ncm }}</td>
        </tr>
        <tr>
            <th>Payment Term</th>
            <td>:</td>
            <td>{{ $transaction->payment_term }}</td>
            <th></th>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="custom-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 30%">Item Description</th>
                <th class="text-center">Carton (PCS)</th>
                <th class="text-center">Inner<br>(PCS)</th>
                <th class="text-center">Unit Price (USD/KG)</th>
                <th class="text-center">Net Weight (KG)</th>
                <th class="text-center">Price Amount (USD)</th>
            </tr>
        </thead>
        <tbody id="detail-rows">
            @foreach ($detailTransactions as $detailTransaction)
            <tr>
                <td class="custom-description">
                    <strong>{{ $detailTransaction->detailProduct->name }}
                    {{ $detailTransaction->detailProduct->pcs }} PCS / {{ $detailTransaction->qty }} KG</strong><br>
                    {{ $detailTransaction->detailProduct->dimension }} 
                    {{ $detailTransaction->detailProduct->color }} 
                    {{ $detailTransaction->detailProduct->type }}
                </td>
                <td>{{ $detailTransaction->carton }}</td>
                <td>{{ $detailTransaction->inner_qty_carton }}</td>
                <td>{{ $detailTransaction->unit_price }}</td>
                <td>{{ $detailTransaction->net_weight }}</td>
                <td>{{ $detailTransaction->price_amount }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr id="totalRow">
                <td style="text-align: center">Amount</td>
                <td class="custom-bg-red" id="totalCarton">{{ $totalCarton }}</td>
                <td class="custom-bg-red" id="totalInner">{{ $totalInner }}</td>
                <td class="custom-bg-red"></td>
                <td class="custom-bg-red" id="totalNetWeight">{{ $totalNetWeight }}</td>
                <td class="custom-bg-red" id="PriceAmount">{{ $priceAmount }}</td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="5">FREIGHT COST</td>
                <td class="custom-bg-red">{{ $transaction->freight_cost }}</td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="5">TOTAL</td>
                <td class="custom-bg-red">{{ $transaction->total }}</td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; margin-top: 3mm">
        <tr style="text-align: right"><td><strong><em>{{ $totalInWords }} USD</em></strong></td></tr>
        <tr style="text-align: right"><td><em>Payment Condition: {{ $transaction->payment_condition}}</em></td></tr>
    </table>

    <table class="approve-section">
        <tr>
            <td><p style="font-weight: bold">Approved By</p></td>
        </tr>
        <tr>
            <td><img src="{{ $ttd }}" alt="Tanda Tangan" style="width: 60px;"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;">{{ $transaction->approverUser->name }}</td>
        </tr>
        <tr>
            <td>{{ $transaction->approverUser->role }}</td>
        </tr>
    </table>
</body>
</html>