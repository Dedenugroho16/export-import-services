<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Statement</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #a3a3a3; padding: 8px; }
        th { background-color: #36c1eb; }
        h1 { text-align: center; }
        .text-center { text-align: center; }
        .table-wrapper {
            display: table;
            width: 100%;
        }
        .table-container {
            display: table-cell;
            width: 50%;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .approve-section {
        width: auto;
        border: none;
        text-align: center;
        float: right;
        margin-top: 10mm;
        }
        .approve-section th, .approve-section td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>
    <div style="text-align: center">
        <img src="{{ $logo ?? '' }}" alt="Logo" style="width: 230px;">
        <h4 style="margin: 0;">PT. PSN STATEMENT - {{ $company_name }} <br>YEAR OF {{ $year }}</h4>
    </div>
    
    <div class="table-wrapper">
        <!-- Tabel Invoices -->
        <div class="table-container">
            <h3 class="text-center mb-4" style="text-decoration: underline;"><strong>INVOICES</strong></h3>
            <div id="rekap-table" class="table-responsive">
                <table class="table table-borderless table-vcenter table-nowrap" id="invoicesTable">
                    <thead class="border-end border-dark">
                        <tr>
                            <th class="text-center">DATE</th>
                            <th class="text-center">INVOICE NO</th>
                            <th class="text-center">AMOUNT USD</th>
                            <th class="text-center">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $invoice)
                            <tr>
                                <td class="text-center">{{ $invoice->date }}</td>
                                <td class="text-center">{{ $invoice->number }}</td>
                                <td class="text-center">{{ number_format($invoice->total) }}</td>
                                <td class="text-center">{{ number_format($invoice->balance) }}</td>
                            </tr>
                        @endforeach
                    </tbody>     
                    <tfoot>
                        <tr id="totalBalance" style="font-weight: bold;">
                            <td class="text-center">TOTAL</td>
                            <td colspan="2"></td>
                            <td class="text-center" id="totalBalanceInvoice">
                                {{ number_format($transactions->sum('total')) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tabel Payments -->
        <div class="table-container">
            <h3 class="text-center mb-4" style="text-decoration: underline;"><strong>PAYMENTS</strong></h3>
            <div id="payment-table" class="table-responsive">
                <table class="table table-borderless table-vcenter table-nowrap" id="paymentsTable">
                    <thead class="border-start border-dark">
                        <tr>
                            <th class="text-center">DATE</th>
                            <th class="text-center">DESCRIPTION</th>
                            <th class="text-center">PAYMENT USD</th>
                            <th class="text-center">BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">{{ $payment->date }}</td>
                                <td class="text-center">{{ $payment->payment_number }}</td>
                                <td class="text-center">{{ number_format($payment->total) }}</td>
                                <td class="text-center">{{ number_format($payment->balance) }}</td>
                            </tr>
                        @endforeach
                    </tbody>                    
                    <tfoot>
                        <tr id="totalBalance" style="font-weight: bold;">
                            <td class="text-center">TOTAL</td>
                            <td colspan="2"></td>
                            <td class="text-center" id="totalBalancePayment">
                                {{ number_format($payments->sum('total')) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-6">
        <div class="border border-dark px-1 py-1 bg-light text-center">
            <h4 class="m-0">BALANCE: 
                {{ number_format($payments->sum('total') - $transactions->sum('total')) }}
            </h4>
        </div>
    </div>

    <table class="approve-section">
        <tr>
            <td>Cianjur, {{ now()->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td><img src="{{ $signature }}" alt="Tanda Tangan" style="width: 100px; margin-top:5mm;"></td>
        </tr>
        <tr>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td>{{ $user->role }}</td>
        </tr>
    </table>
</body>
</html>