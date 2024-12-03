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
    </style>
</head>
<body>
    <div style="text-align: center">
        <img src="{{ $logo ?? '' }}" alt="Logo" style="width: 230px;">
        <h4 style="margin: 0;">PT. PSN STATEMENT - {{ $year }}<br>{{ $company_name }}</h4>
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
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ number_format($invoice->total, 2) }}</td>
                                <td>{{ number_format($invoice->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>     
                    <tfoot>
                        <tr id="totalBalance" style="font-weight: bold;">
                            <td class="text-center">TOTAL</td>
                            <td colspan="2"></td>
                            <td class="text-center" id="totalBalanceInvoice">
                                {{ number_format($invoices->sum('total'), 2) }}
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
                                <td>{{ date('d/m/Y', strtotime($payment->date)) }}</td>
                                <td>{{ $payment->payment_number }}</td>
                                <td>{{ number_format($payment->total, 2) }}</td>
                                <td>{{ number_format($payment->balance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>                    
                    <tfoot>
                        <tr id="totalBalance" style="font-weight: bold;">
                            <td class="text-center">TOTAL</td>
                            <td colspan="2"></td>
                            <td class="text-center" id="totalBalancePayment">
                                {{ number_format($payments->sum('total'), 2) }}
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
                {{ number_format($invoices->sum('total') - $payments->sum('total'), 2) }}
            </h4>
        </div>
    </div>

    <script>
        // Script untuk menghitung saldo kumulatif dan menampilkan data dengan format yang benar
        let totalBalanceInvoice = {{ $invoices->sum('total') }};
        let totalBalancePayment = {{ $payments->sum('total') }};
        let balance = totalBalanceInvoice - totalBalancePayment;

        document.getElementById("totalBalanceInvoice").innerText = new Intl.NumberFormat('en-US', { style: 'decimal' }).format(totalBalanceInvoice);
        document.getElementById("totalBalancePayment").innerText = new Intl.NumberFormat('en-US', { style: 'decimal' }).format(totalBalancePayment);
        document.getElementById("balanceValue").innerText = new Intl.NumberFormat('en-US', { style: 'decimal' }).format(balance);
    </script>
</body>
</html>