@extends('layouts.layout')
@section('title', 'Payment Details')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mb-4 mt-4 d-flex justify-content-between">
                <a href="{{ route('bill-of-payments.index') }}" class="btn btn-primary">
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
                            <a class="dropdown-item" href="#"
                                target="_blank">
                                Ekspor PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
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
                                    <h1>PAYMENT DETAILS</h1>
                                </div>
                            </div>
                            <div>
                                <table class="table-sm mb-6" style="font-size: 15px">
                                    <tr>
                                        <td style="width: 20%">DATE</td>
                                        <td style="width: 5px">:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->created_at->format('F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>PAYMENT NUMBER</td>
                                        <td>:</td>
                                        <td style="font-weight: bold"></td>
                                    </tr>
                                    <tr>
                                        <td>BUYER NAME</td>
                                        <td>:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->client->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>COMPANY NAME</td>
                                        <td>:</td>
                                        <td style="font-weight: bold">{{ $billOfPayment->client->company_name}}</td>
                                    </tr>
                                </table>
                                <div>
                                    <div>
                                        <table class="table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">PROFORMA INVOICE NUMBER</th>
                                                    <th class="text-center">CODE</th>
                                                    <th class="text-center">DATE</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">TRANSFERED</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($billOfPayment->transactions as $index => $transaction)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $transaction->number }}</td>
                                                    <td class="text-center">{{ $transaction->code }}</td>
                                                    <td class="text-center">{{ $transaction->date->format('F d, Y') }}</td>
                                                    <td class="text-end amount">{{ number_format($transaction->amount) }}</td>
                                                    <td class="text-end paid">{{ number_format($transaction->paid) }}</td>
                                                    <td>{{ ($transaction->description) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data transaksi</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr id="totalRow" style="border: none">
                                                    <td class="text-end" colspan="5" style="border: none">AMOUNT OF PAYMENT</td>
                                                    <td class="text-end bg-black text-white" style="font-weight: bold; border:none">{{ number_format($totalPaid) }}</td>
                                                    <td class="text-center" style="border: none"></td>
                                                </tr>
                                                <tr style="border: none">
                                                    <td class="text-end" colspan="6" style="font-weight: bold; border:none"><em>{{ $totalInWords }} USD</em></td>
                                                    <td style="border: none"></td>
                                                </tr>
                                            </tfoot>
                                        </table>                                       
                                        <div class="mt-6">
                                            <table class="text-center" style="width: auto; float:right;">
                                                <tr>
                                                    <td><p style="font-weight: bold">Approved By</p></td>
                                                </tr>
                                                <tr>
                                                    <td><img src="{{ asset('storage/' . $billOfPayment->createdBy->signature_url) }}" alt="Signature"
                                                        width="100px" style="margin-bottom: 10px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom: 1px solid black;">{{ $billOfPayment->createdBy ? $billOfPayment->createdBy->name : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $billOfPayment->createdBy ? $billOfPayment->createdBy->role : 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div>
                                            <table class="table-sm mt-6" style="font-size: 14px; float:left">
                                                <tr>
                                                    <td style="font-weight: bold" colspan="3">REMITTANCE ADVISE</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 25%">Beneficiary Account Name</td>
                                                    <td>:</td>
                                                    <td style="font-weight: bold">{{$company->bank_account_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Beneficiary Account Number</td>
                                                    <td>:</td>
                                                    <td style="font-weight: bold">{{$company->bank_account_number}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Beneficiary Bank Name</td>
                                                    <td>:</td>
                                                    <td style="font-weight: bold">{{$company->bank_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Beneficiary Bank Address</td>
                                                    <td>:</td>
                                                    <td style="font-weight: bold">{{$company->bank_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Swift Code</td>
                                                    <td>:</td>
                                                    <td style="font-weight: bold">{{$company->swift_code}}</td>
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
    </div>     
@endsection