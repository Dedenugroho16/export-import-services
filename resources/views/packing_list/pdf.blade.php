<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
         .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .company-name {
            font-size: 50px;
            font-weight: 500;
        }

        .company-details p {
            font-weight: 500;
            margin: 0;
        }

        .header-right-table {
            width: auto;
            margin-left: auto;
        }

        .header-right-table td {
            padding: 3px 10px;
            font-size: 13px;
        }

        .codeTable {
            text-align: right;
        }

        .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 50px
    }
    .custom-table th, .custom-table td {
        border: 1px solid #666464;
        padding: 8px;
    }
    .custom-table tfoot td {
        font-weight: bold;
    }
    .custom-bg-success {
        background-color: #28a745;
        color: white;
    }
    .text-center{
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    <em class="company-name">PT. PSN</em><br>
                    <div class="company-details">
                        <p>PRINGGONDANI SETIA NUSANTARA</p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <table class="header-right-table">
                        <tr>
                            <td>Date</td>
                            <td>:</td>
                            <td class="codeTable">{{ $transaction->date }}</td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td>:</td>
                            <td class="codeTable">{{ $transaction->code }}</td>
                        </tr>
                        <tr>
                            <td>Number</td>
                            <td>:</td>
                            <td class="codeTable">{{ $transaction->number }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <h2 style="text-align: center; margin-bottom: 50px">PACKING LIST</h2>

        <div class="info-section" style="width: 100%; margin-bottom: 50px">
            <div class="card" style="display: inline-block; width: 30%; vertical-align: top; margin-right: 10px;">
                <p style="font-weight: bold">Consignee</p>
                <p>{{ $transaction->consignee->name }}</p>
                <p>{{ $transaction->consignee->address }}</p>
                <p>{{ $transaction->consignee->tel }}</p>
            </div>
            <div class="card" style="display: inline-block; width: 30%; vertical-align: top; margin-right: 10px;">
                <p style="font-weight: bold">Notify</p>
                <p>{{ $transaction->notify }}</p>
            </div>
            <div class="card" style="display: inline-block; width: 30%; vertical-align: top;">
                <p style="font-weight: bold">Client</p>
                <p>{{ $transaction->client->name }}</p>
                <p>{{ $transaction->client->address }}</p>
                <p>{{ $transaction->client->tel }}</p>
            </div>
        </div>

        <div class="section-tiga" style="width: 100%; text-align: center; margin-bottom: 50px">
            <div class="card" style="display: inline-block; width: 20%; margin: 10px;">
                <p style="font-weight: bold">Port of loading</p>
                <p>{{ $transaction->port_of_loading }}</p>
            </div>
            <div class="card" style="display: inline-block; width: 20%; margin: 10px;">
                <p style="font-weight: bold">Place of receipt</p>
                <p>{{ $transaction->place_of_receipt }}</p>
            </div>
            <div class="card" style="display: inline-block; width: 20%; margin: 10px;">
                <p style="font-weight: bold">Place of discharge</p>
                <p>{{ $transaction->port_of_discharge }}</p>
            </div>
            <div class="card" style="display: inline-block; width: 20%; margin: 10px;">
                <p style="font-weight: bold">Place of delivery</p>
                <p>{{ $transaction->place_of_delivery }}</p>
            </div>
        </div>

        <div class="group-info" style="width: 100%; margin-top: 20px; margin-bottom: 50px">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <!-- Tabel Kiri -->
                    <td style="width: 60%; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 30%;"><strong>Name of Product</strong></td>
                                <td style="width: 10%; text-align: center;">:</td>
                                <td style="width: 60%;">{{ $transaction->product->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Name of Commodity</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->commodity->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Container</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->container }}</td>
                            </tr>
                            <tr>
                                <td><strong>Net Weight</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->net_weight }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gross Weight</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->gross_weight }}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment Term</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->payment_term }}</td>
                            </tr>
                        </table>
                    </td>
                    <!-- Tabel Kanan -->
                    <td style="width: 40%; vertical-align: top;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 40%;"><strong>Stuffing Date</strong></td>
                                <td style="width: 10%; text-align: center;">:</td>
                                <td style="width: 50%;">{{ $transaction->stuffing_date }}</td>
                            </tr>
                            <tr>
                                <td><strong>BL Number</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->bl_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Container Number</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->container_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Seal Number</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->seal_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Product NCM</strong></td>
                                <td style="text-align: center;">:</td>
                                <td>{{ $transaction->product_ncm }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        
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
                    <td class="custom-description">
                        <strong>{{ $detailTransaction->detailProduct->name }}
                        {{ $detailTransaction->detailProduct->pcs }} PCS / {{ $detailTransaction->qty }} KG</strong><br>
                        {{ $detailTransaction->detailProduct->dimension }} 
                        {{ $detailTransaction->detailProduct->color }} 
                        {{ $detailTransaction->detailProduct->type }}
                    </td>
                    <td>{{ $detailTransaction->carton }}</td>
                    <td>{{ $detailTransaction->inner_qty_carton }}</td>
                    <td>{{ $detailTransaction->net_weight }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr id="totalRow">
                    <td class="text-center">Amount</td>
                    <td class="text-center custom-bg-success" id="totalCarton">0</td>
                    <td class="text-center custom-bg-success" id="totalInner">0</td>
                    <td class="text-center custom-bg-success" id="totalNetWeight">0</td>
                </tr>
            </tfoot>
        </table>

        <div>
            <table style="width: 100%">
                <tr>
                    <td style="text-align: end"><p>Approver</p></td>
                </tr>
                <tr>
                    <td style="text-align: end">Director</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

