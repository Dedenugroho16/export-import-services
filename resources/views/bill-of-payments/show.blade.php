@extends('layouts.layout')
@section('title', 'Bill of Payment')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mb-4 mt-4 d-flex justify-content-between">
                <a href="{{ route('bill-of-payment.index') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M5 12l6 6" />
                        <path d="M5 12l6 -6" />
                    </svg>
                    Kembali
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                        </svg>
                        Ekspor/Download
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('billofpayments.exportPdf', $hashedId) }}"
                                target="_blank">
                                Ekspor PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('billofpayments.downloadPdf', $hashedId) }}">
                                Download PDF
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-body p-5">
                            <!-- Hader -->
                            <div class="container">
                                <div class="d-flex align-items-center">
                                    @if (isset($company) && !empty($company->logo))
                                        <img src="{{ Storage::url($company->logo) }}" alt="Company Logo" style="width: 60px;">
                                    @else
                                        <img src="" alt="Logo Perusahaan" style="width: 60px;">
                                    @endif
                                    <div style="padding-left: 10px;">
                                        <em style="font-size: 60px; font-weight:500;">PT. PSN</em><br>
                                        <p style="font-weight:500; margin: 0;">PRINGGONDANI SETIA NUSANTARA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-6 mb-6">
                                <div class="col-md-12 text-center">
                                    <h1>BILL OF PAYMENT</h1>
                                </div>
                            </div>
                            <div>
                                <table class="table-sm mb-6" style="font-size: 15px">
                                    <tr>
                                        <td style="width: 20%">Month</td>
                                        <td style="width: 5px">:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->month }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Inv</td>
                                        <td>:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->no_inv }}</td>
                                    </tr>
                                    <tr>
                                        <td>Buyer Name</td>
                                        <td>:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->client->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Company Name</td>
                                        <td>:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->client->company_name }}</td>
                                    </tr>
                                </table>
                            
                                <div>
                                    <table class="table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">PI NUMBER</th>
                                                <th class="text-center">CODE</th>
                                                <th class="text-center">DESCRIPTION</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">PAID</th>
                                                <th class="text-center">BILL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($billOfPayment->descBills as $index => $descBill)
                                                @if ($descBill->transaction)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td class="text-center">{{ $descBill->transaction->number }}</td>
                                                        <td class="text-center">{{ $descBill->transaction->code }}</td>
                                                        <td>{{ $descBill->description }}</td>
                                                        <td class="text-end amount">{{ number_format($descBill->transaction->total) }}</td>
                                                        <td class="text-end paid">{{ number_format($descBill->transaction->paid) }}</td>
                                                        <td class="text-end bill">{{ number_format($descBill->transaction->bill) }}</td>
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
                                                <td class="text-end" colspan="6">AMOUNT OF BILL</td>
                                                <td class="text-end bg-black text-white">{{ number_format($totalBill) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                    <div class="mt-3">
                                        <div class="text-end">
                                            <p><strong><em>In Words: {{ $totalInWords }} USD</em></strong></p>
                                        </div>
                                    </div>
                            
                                    <div>
                                        <table class="table-sm mt-6" style="font-size: 14px">
                                            <tr>
                                                <td style="font-weight: bold" colspan="3">REMITTANCE ADVISE</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%">Beneficiary Account Name</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $company->bank_account_name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Beneficiary Account Number USD</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $company->bank_account_number ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Beneficiary Bank Name</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $company->bank_name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Beneficiary Bank Address</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $company->bank_address ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Swift Code</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">{{ $company->swift_code ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                            
                                    <div class="mt-6">
                                        <table class="text-center" style="width: auto; float:right">
                                            <tr>
                                                <td>{{ $billOfPayment->created_at->format('F d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><p style="font-weight: bold">Approved By</p></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $billOfPayment->createdBy->signature_url) }}" alt="Signature" width="100px" style="margin-bottom: 10px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid black;">{{ $billOfPayment->createdBy->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $billOfPayment->createdBy->role }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
@endsection