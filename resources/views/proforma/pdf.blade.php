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
        margin-top: 7mm;
    }

    .section-tiga {
        width: 100%;
        margin-top: 7mm;
        text-align: center;
        font-size: 17px;
    }

    .section-empat {
        width: 100%;
        margin-top: 7mm;
    }

    .section-empat th {
        text-align: left;
    }

    .custom-table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 7mm;
    }
    .custom-table th, .custom-table td {
        border: 1px solid black;
        padding: 5px;
    }
    .custom-table tfoot td {
        font-weight: bold;
    }
    .custom-bg-red {
        background-color: #d82d2d;
        color: white;
        text-align: center;
    }
    .approve-section {
        width: auto;
        font-size: 15px;
        text-align: center;
        float: right;
        margin-top: 2mm;
    }
    .footer {
        font-family: Arial, Helvetica, sans-serif;
            text-align: left;
            font-size: 12px;
            position: absolute;
            bottom: 0;
            width: 100%;
    } 
</style>
<body>
    <table class="section-satu">
        <tr>
            <td>
                <table>
                    <tr>
                        <td><img src="{{ $logo }}" alt="Company Logo" style="width: 50px;"></td>
                        <td><em style="font-size: 50px; font-weight: bold;">PT.PSN</em>
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
                        <td style="text-align: right">{{ $proformaInvoice->date }}</td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td>:</td>
                        <td style="text-align: right">{{ $proformaInvoice->code }}</td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td>:</td>
                        <td style="text-align: right">{{ $proformaInvoice->number }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h2 style="text-align: center">PROFORMA INVOICE</h2>

    <table class="section-dua">
            <tr>
                <td style="width: 33%; font-weight: bold; font-size: 15px">CONSIGNEE</td>
                <td style="width: 33%; font-weight: bold; font-size: 15px">NOTIFY</td>
                <td style="width: 33%; font-weight: bold; font-size: 15px">CLIENT</td>
            </tr>
            <tr>
                <td style="font-weight: 300">{{ $proformaInvoice->consignee->name }}</td>
                <td style="font-weight: 300">{{ $proformaInvoice->notify }}</td>
                <td style="font-weight: 300">{{ $proformaInvoice->client->name }}</td>
            </tr>
            <tr>
                <td>{{ $proformaInvoice->consignee->address }}</td>
                <td></td>
                <td>{{ $proformaInvoice->client->address }}</td>
            </tr>
            <tr>
                <td>{{ $proformaInvoice->consignee->tel }}</td>
                <td></td>
                <td>{{ $proformaInvoice->client->tel }}</td>
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
            <td>{{ $proformaInvoice->port_of_loading }}</td>
            <td>{{ $proformaInvoice->place_of_receipt }}</td>
            <td>{{ $proformaInvoice->port_of_discharge}}</td>
            <td>{{ $proformaInvoice->place_of_delivery }}</td>
        </tr>
    </table>

    <table class="section-empat">
        <tr>
            <th style="width: 25%">Name of Product</th>
            <td style="width: 2%;">:</td>
            <td style="width: 40%">{{ $proformaInvoice->product->name }}</td>
            <th>Net Weight</th>
            <td style="width: 2%;">:</td>
            <td>{{ $proformaInvoice->net_weight }}</td>
        </tr>
        <tr>
            <th>Name of Commodity</th>
            <td>:</td>
            <td>{{ $proformaInvoice->commodity->name }}</td>
            <th>Gross Weight</th>
            <td>:</td>
            <td>{{ $proformaInvoice->gross_weight }}</td>
        </tr>
        <tr>
            <th>Container</th>
            <td>:</td>
            <td>{{ $proformaInvoice->container }}</td>
            <th>Product NCM</th>
            <td>:</td>
            <td>{{ $proformaInvoice->product_ncm }}</td>
        </tr>
        <tr>
            <th>Payment Term</th>
            <td>:</td>
            <td>{{ $proformaInvoice->payment_term }}</td>
            <td></td>
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
                <td class="custom-bg-red">{{ $proformaInvoice->freight_cost }}</td>
            </tr>
            <tr>
                <td style="text-align: right" colspan="5">TOTAL</td>
                <td class="custom-bg-red">{{ $proformaInvoice->total }}</td>
            </tr>
        </tfoot>
    </table>

    <table style="width: 100%; margin-top: 2mm">
        <tr style="text-align: right"><td><strong><em>{{ $totalInWords }} USD</em></strong></td></tr>
        <tr style="text-align: right"><td><em>Payment Condition: FOB (Free on Board)</em></td></tr>
    </table>

    <table class="approve-section">
        <tr>
            <td><p style="font-weight: bold">Approved By</p></td>
        </tr>
        <tr>
            <td><img src="{{ $ttd }}" alt="Tanda Tangan" style="width: 60px;"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;">{{ $proformaInvoice->approverUser->name }}</td>
        </tr>
        <tr>
            <td>{{ $proformaInvoice->approverUser->role }}</td>
        </tr>
    </table>    
    <footer class="footer">
        <table style="font-size: 10px; border-collapse: collapse; width: 100%;">
            <tr>
                <td style="font-weight: bolder;">HEAD OFFICE</td>
                <td>:</td>
                <td>JL.POLINGGA NO.5 KP.WAASRT02/RW13 SABANDAR, KARANG TENGAH, CIANJUR, JAWA BARAT</td>
            </tr>
            <tr>
                <td style="font-weight: bolder;">BRANCH OFFICE</td>
                <td>:</td>
                <td>DS.JIKEN SURUHAN NO.45RT02/RW04 JIKEN, BLORA, JAWA TENGAH</td>
            </tr>
        </table>
        <table>
            <tr>
                <td><img src="{{ $phone }}" alt="" style="width: 15px"></td>
                <td>{{ $company->contact_person}}</td>
                <td></td>
                <td><img src="{{ $email }}" alt="" style="width: 15px"></td>
                <td>{{ $company->email}}</td>
            </tr>
        </table>        
    </footer>
</body>
</html>