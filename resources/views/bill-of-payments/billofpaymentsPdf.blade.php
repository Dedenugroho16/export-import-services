<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill-of-payments-pdf</title>
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
        font-size: 15px;
    }
    .content {
        padding: 8mm 12mm 8mm;
    }
    .section-satu {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 7mm;
        font-size: 14px;
    }
    .info table {
        width: 100%;
        margin-top: 10mm;
    }
    .table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
        margin-top: 10mm;
    }
    .table th, .table td {
        border: 1px solid black;
        padding: 3px;
    }
    .bg-black {
        background-color: #000000;
        color: white;
        text-align: center;
    }
    .bank-info{
        width: 100%;
        margin-top: 10mm;
    }
    .approve-section {
        width: auto;
        text-align: center;
        float: right;
        margin-top: 10mm;
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
        </tr>
    </table>

    <h2 style="text-align: center">BILL OF PAYMENT</h2>

    <div class="info">
        <table >
            <tr>
                <td style="width: 25%">Month</td>
                <td style="width: 2%">:</td>
                <td style="font-weight: bold">{{ $billOfPayment->month}}</td>
            </tr>
            <tr>
                <td>No. Inv</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $billOfPayment->no_inv}}</td>
            </tr>
            <tr>
                <td>Buyer Name</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $billOfPayment->client->name}}</td>
            </tr>
            <tr>
                <td>Company Name</td>
                <td>:</td>
                <td style="font-weight: bold">{{ $billOfPayment->clientCompany->company_name }}</td>
            </tr>
        </table>
    </div>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PI NUMBER</th>
                    <th>CODE</th>
                    <th>DESCRIPTION</th>
                    <th>AMOUNT</th>
                    <th>PAID</th>
                    <th>BILL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($billOfPayment->descBills as $index => $descBill)
                    @if ($descBill->transaction)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $descBill->transaction->number }}</td>
                            <td style="text-align: center;">{{ $descBill->transaction->code }}</td>
                            <td>{{$descBill->description }}</td>
                            <td style="text-align: right;">{{ number_format($descBill->transaction->total) }}</td>
                            <td style="text-align: right;">{{ number_format($descBill->paid) }}</td>
                            <td style="text-align: right;">{{ number_format($descBill->transaction->bill) }}</td>
                        </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                 @endforelse
            </tbody>
            <tfoot>
                <tr id="totalRow" style="font-weight: bold;">
                    <td style="text-align: right;" colspan="6">AMOUNT OF BILL</td>
                    <td class="bg-black" style="text-align: right;">{{ number_format($totalBill) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <table style="width: 100%; margin-top: 1mm">
        <tr style="text-align: right"><td><strong><em>In Words: {{ $totalInWords }} USD</em></strong></tr>
    </table>
    <div>
        <table class="bank-info">
            <tr>
                <td style="font-weight: bold">REMITTANCE ADVISE</td>
            </tr>
            <tr>
                <td style="width: 35%">Beneficiary Account Name</td>
                <td style="width: 2%">:</td>
                <td style="font-weight: bold">{{$company->bank_account_name ?? '-'}}</td>
            </tr>
            <tr>
                <td>Beneficiary Account Number USD</td>
                <td>:</td>
                <td style="font-weight: bold">{{$company->bank_account_number ?? '-'}}</td>
            </tr>
            <tr>
                <td>Beneficiary Bank Name</td>
                <td>:</td>
                <td style="font-weight: bold">{{$company->bank_name ?? '-'}}</td>
            </tr>
            <tr>
                <td>Beneficiary Bank Address</td>
                <td>:</td>
                <td style="font-weight: bold">{{$company->bank_address ?? '-'}}</td>
            </tr>
            <tr>
                <td>Swift Code</td>
                <td>:</td>
                <td style="font-weight: bold">{{$company->swift_code ?? '-'}}</td>
            </tr>
        </table>
    </div>

    <table class="approve-section">
        <tr>
            <td>{{ $billOfPayment->created_at->format('F d, Y')}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold">Approved By</td>
        </tr>
        <tr>
            <td><img src="{{ $signature }}" alt="Tanda Tangan" style="width: 100px; margin-top:5mm;"></td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;">{{ $billOfPayment->createdBy ? $billOfPayment->createdBy->name : 'N/A' }}</td>
        </tr>
        <tr>
            <td>{{ $billOfPayment->createdBy ? $billOfPayment->createdBy->role : 'N/A' }}</td>
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