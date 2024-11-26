<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Packing List</title>
</head>
<style>
    @page {
         margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ public_path("storage/background.jpg") }}');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center;
        font-size: 14px;
    }
    .content {
        padding: 8mm 12mm 8mm;
    }
    .section-satu {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 7mm;
    }

    .section-dua {
        width: 100%;
        margin-top: 10mm;
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
        margin-top: 3mm;
        text-align: right;
    }
    .custom-table th, .custom-table td {
        border: 1px solid black;
        padding: 3px;
    }
    .custom-table tfoot td {
        font-weight: bold;
    }
    .custom-bg-green {
        background-color: #28a745;
        color: white;
        text-align: center;
    }
    .approve-section {
        width: auto;
        font-size: 14px;
        text-align: center;
        float: right;
        margin-top: 2mm;
    }
    .footer {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        font-size: 12px;
        position: absolute;
        bottom: 10mm;
        width: 100%;
    }  
</style>
<body>
    <div class="content">
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
                        <td style="text-align: right">{{ \Carbon\Carbon::parse($transaction->date)->format('l, F d, Y') }}</td>
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

    <h2 style="text-align: center">PACKING LIST</h2>

    <table class="section-dua" style="width: 100%; border-collapse: collapse;">
        <tr>
            <!-- Tabel Consignee -->
            <td style="vertical-align: top; width: 33%; border-left: 1px solid #000000;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold; font-size: 15px;">CONSIGNEE</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">{{ $transaction->consignee->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $transaction->consignee->address }}</td>
                    </tr>
                    <tr>
                        <td>TEL : {{ $transaction->consignee->tel }}</td>
                    </tr>
                </table>
            </td>
    
            <!-- Tabel Notify -->
            <td style="vertical-align: top; width: 33%; border-left: 1px solid #000000;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold; font-size: 15px;">NOTIFY</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">{{ $transaction->notify }}</td>
                    </tr>
                </table>
            </td>
    
            <!-- Tabel Client -->
            <td style="vertical-align: top; width: 33%; border-left: 1px solid #000000;">
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold; font-size: 15px;">CLIENT</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">{{ $transaction->client->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $transaction->client->address }}</td>
                    </tr>
                    <tr>
                        <td>P.O BOX : {{ $transaction->client->PO_BOX }}</td>
                    </tr>
                    <tr>
                        <td>TEL : {{ $transaction->client->tel }}</td>
                    </tr>
                    <tr>
                        <td>FAX : {{ $transaction->client->fax }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>    

    <table class="section-tiga">
        <tr>
            <td>Port of loading</td>
            <td>Place of receipt</td>
            <td>Port of discharge</td>
            <td>Place of delivery</td>
        </tr>
        <tr style="font-size: 14px">
            <td style="font-weight: bold">{{ $transaction->port_of_loading }}</td>
            <td style="font-weight: bold">{{ $transaction->place_of_receipt }}</td>
            <td style="font-weight: bold">{{ $transaction->port_of_discharge}}</td>
            <td style="font-weight: bold">{{ $transaction->place_of_delivery }}</td>
        </tr>
    </table>

    <table class="section-empat">
        <tr>
            <th>Name of Product</th>
            <td>:</td>
            <td>{{ $transaction->product->name }}</td>
            <th>Stuffing Date</th>
            <td>:</td>
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
            <td>{{ formatCurrency($transaction->net_weight) }}</td>
            <th>Seal Number</th>
            <td>:</td>
            <td>{{ $transaction->seal_number }}</td>
        </tr>
        <tr>
            <th>Gross Weight</th>
            <td>:</td>
            <td>{{ formatCurrency($transaction->gross_weight) }}</td>
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
                <th class="text-center">Item Description</th>
                <th class="text-center">Carton (pcs)</th>
                <th class="text-center">Inner (pcs)</th>
                <th class="text-center">Net Weight (KG)</th>
            </tr>
        </thead>
        <tbody id="detail-rows">
            @foreach ($detailTransactions as $detailTransaction)
            <tr>
                <td style="text-align: left;">
                    <strong>{{ $detailTransaction->detailProduct->name }}
                    {{ formatCurrency($detailTransaction->detailProduct->pcs) }} PCS / 
                    {{ formatCurrency($detailTransaction->qty) }} KG</strong><br>
                    {{ $detailTransaction->detailProduct->dimension }} 
                    {{ $detailTransaction->detailProduct->color }} 
                    {{ $detailTransaction->detailProduct->type }}
                </td>
                <td class="carton">{{ formatCurrency($detailTransaction->carton) }}</td>
                <td class="inner">{{ formatCurrency($detailTransaction->inner_qty_carton) }}</td>
                <td class="net-weight">{{ formatCurrency($detailTransaction->net_weight) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr id="totalRow">
                <td style="text-align: center">Amount</td>
                <td class="text-center custom-bg-green" id="totalCarton">{{ formatCurrency($totalCarton) }}</td>
                <td class="text-center custom-bg-green" id="totalInner">{{ formatCurrency($totalInner) }}</td>
                <td class="text-center custom-bg-green" id="totalNetWeight">{{ formatCurrency($totalNetWeight) }}</td>
            </tr>
        </tfoot>
    </table>

    <table class="approve-section">
        <tr>
            <td><p style="font-weight: bold">Approved By</p></td>
        </tr>
        <tr>
            <td><img src="{{ $signature }}" alt="Tanda Tangan" style="width: 80px;"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;">{{ $transaction->approverUser->name }}</td>
        </tr>
        <tr>
            <td>{{ $transaction->approverUser->role }}</td>
        </tr>
    </table>
    <footer class="footer">
        <table style="font-size: 10px; border-collapse: collapse; width: 100%;">
            <tr>
                <td style="font-weight: bolder; color:rgb(2, 107, 228);">HEAD OFFICE</td>
                <td>:</td>
                <td>{{ $company->address ?? 'JL.POLINGGA NO.5 RT.02/RW.13 SABANDAR, KARANG TENGAH, CIANJUR, JAWA BARAT - INDONESIA' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bolder; color:rgb(2, 107, 228);">BRANCH OFFICE</td>
                <td>:</td>
                <td>DS.JIKEN SURUHAN NO.45RT02/RW04 JIKEN, BLORA, JAWA TENGAH</td>
            </tr>
        </table>
        <table>
            <tr>
                @if ($company)
                <td>
                    <img src="{{ $phoneIcon ?? '' }}" alt="Phone Icon" style="width: 15px">
                </td>
                <td>
                    {{ $company->phone_number ?? '' }}
                </td>
                <td></td>
                <td>
                    <img src="{{ $emailIcon ?? '' }}" alt="Email Icon" style="width: 15px">
                </td>
                <td>
                    {{ $company->email ?? '' }}
                </td>
            @else
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            @endif
            </tr>
        </table>        
    </footer>
</div>
</body>
</html>