<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
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
        }

        .codeTable {
            text-align: right;
        }

        /* Style for Consignee, Notify, and Client section */
        .info-section {
            width: 100%;
            border-spacing: 20px;
            margin-top: 20px;
            text-align: center;
        }

        .info-section td {
            vertical-align: top;
            padding: 0 10px;
        }

        .info-section h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .info-section p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* To make sure the three sections are aligned side by side */
        .consignee, .notify, .client {
            width: 33%;
        }

        .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .custom-table th, .custom-table td {
        border: 1px solid #000;
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

    <h2 style="text-align: center">PACKING LIST</h2>

    <div>
        <table class="info-section">
            <tr>
                <!-- Consignee Section -->
                <td class="consignee">
                    <h3>Consignee</h3>
                    <p>{{ $transaction->consignee->name }}</p>
                    <p>{{ $transaction->consignee->address }}</p>
                    <p>{{ $transaction->consignee->tel }}</p>
                </td>
        
                <!-- Notify Section -->
                <td class="notify">
                    <h3>Notify</h3>
                    <p>{{ $transaction->notify }}</p>
                </td>
        
                <!-- Client Section -->
                <td class="client">
                    <h3>Client</h3>
                    <p>{{ $transaction->client->name }}</p>
                    <p>{{ $transaction->client->address }}</p>
                    <p>{{ $transaction->client->tel }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div>
        <table style="width: 100%; border-spacing: 20px; text-align:center;">
            <tr>
                <!-- Consignee Section -->
                <td style="vertical-align: top; width: 33%;">
                    <h3>Port of loading</h3>
                    <p><p>{{ $transaction->port_of_loading }}</p></p>
                </td>
        
                <!-- Notify Section -->
                <td style="vertical-align: top; width: 33%;">
                    <h3>Place of receipt</h3>
                    <p>{{ $transaction->place_of_receipt }}</p>
                </td>
        
                <!-- Client Section -->
                <td style="vertical-align: top; width: 33%;">
                    <h3>Port of discharge</h3>
                    <p>{{ $transaction->port_of_discharge }}</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td>Name of product</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->product->name }}</p></td>
                    </tr>
                    <tr>
                        <td>Name of Commodity</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->commodity->name }}</p></td>
                    </tr>
                    <tr>
                        <td>Container</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->container }}</p></td>
                    </tr>
                    <tr>
                        <td>Net weight</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->net_weight }}</p></td>
                    </tr>
                    <tr>
                        <td>Gross weight</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->gross_weight }}</p></td>
                    </tr>
                    <tr>
                        <td>Payment term</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->payment_term }}</p></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td>Stuffing date</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->stuffing_date }}</p></td>
                    </tr>
                    <tr>
                        <td>BL Number</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->bl_number }}</p></td>
                    </tr>
                    <tr>
                        <td>Container number</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->container_number }}</p></td>
                    </tr>
                    <tr>
                        <td>Seal number</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->seal_number }}</p></td>
                    </tr>
                    <tr>
                        <td>Product NCM</td>
                        <td>:</td>
                        <td><p style="margin: 0;">{{ $transaction->product_ncm }}</p></td>
                    </tr>
                </table>
            </td>
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
</body>
</html>