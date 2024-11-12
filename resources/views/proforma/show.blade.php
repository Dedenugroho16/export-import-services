@extends('layouts.layout')
@section('title', 'Proforma Invoice')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mb-4 mt-4 d-flex justify-content-between">
                <a href="{{ route('proforma.index') }}" class="btn btn-primary">
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
                @if ($approved == 1)
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
                                <a class="dropdown-item" href="{{ route('proforma.exportPdf', ['id' => $hashedId]) }}"
                                    target="_blank">
                                    Ekspor PDF
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('proforma.downloadPdf', ['id' => $hashedId]) }}">
                                    Download PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-body p-5">
                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('transaction_id'))
                                <div class="alert alert-info">
                                    Transaction ID: {{ session('transaction_id') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Hader -->
                            <div class="container">
                                <div class="d-flex justify-content-between align-items-start">
                                    <!-- Kolom Kiri: Logo dan Nama Perusahaan -->
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

                                    <!-- Kolom Kanan: Detail Informasi -->
                                    <div class="row mb-5 mt-3 col-4">
                                        <div>
                                            <table class=" table-sm">
                                                <tr>
                                                    <td><strong>Date</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $proformaInvoice->date }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Code</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $proformaInvoice->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Number</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $proformaInvoice->number }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-6 mb-5">
                                <div class="col-md-12 text-center">
                                    <h1>PROFORMA INVOICE</h1>
                                </div>
                            </div>

                            <!-- Bagian 2: Consignee, Notify, Client -->
                            <div class="row mt-4">
                                <!-- Consignee Input -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Consignee</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>
                                                {{ $proformaInvoice->consignee->name }} <br>
                                                {{ $proformaInvoice->consignee->address }} <br>
                                                {{ $proformaInvoice->consignee->tel }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notify Input -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Notify</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>
                                                {{ $proformaInvoice->notify }} <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Client Input -->
                                <div class="col-md-4">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Client</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>
                                                {{ $proformaInvoice->client->name }} <br>
                                                {{ $proformaInvoice->client->address }} <br>
                                                {{ $proformaInvoice->client->tel }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian 3: Port of Loading, Place of Receipt, Port of Discharge, Place of Delivery -->
                            <div class="row mt-4">
                                <!-- Port of Loading Input -->
                                <div class="col-md-3">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Port of loading</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>{{ $proformaInvoice->port_of_loading }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Place of Receipt Input -->
                                <div class="col-md-3">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Place of receipt</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>{{ $proformaInvoice->place_of_receipt }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Port of Discharge Input -->
                                <div class="col-md-3">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Port of discharge</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>{{ $proformaInvoice->port_of_discharge }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Place of Delivery Input -->
                                <div class="col-md-3">
                                    <div class="card p-2">
                                        <div class="card-header p-2">
                                            <h5 class="card-title">Place of delivery</h5>
                                        </div>
                                        <div class="card-body p-1">
                                            <p>{{ $proformaInvoice->place_of_delivery }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- bagian 4 --}}
                            <div class="table-responsive mt-6 d-flex justify-content-center">
                                <table class="table table-borderless w-100">
                                    <tbody>
                                        <tr>
                                            <!-- Kolom Sebelah Kiri -->
                                            <td class="align-top" style="width: 60%;">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 40%;"><strong>Name of Product</strong></td>
                                                            <td style="width: 5%;">:</td>
                                                            <td>{{ $proformaInvoice->product->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Name of Commodity</strong></td>
                                                            <td>:</td>
                                                            <td>{{ $proformaInvoice->commodity->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Container</strong></td>
                                                            <td>:</td>
                                                            <td>{{ $proformaInvoice->container }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Payment Term</strong></td>
                                                            <td>:</td>
                                                            <td>{{ $proformaInvoice->payment_term }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                            
                                            <!-- Kolom Sebelah Kanan -->
                                            <td class="align-top" style="width: 40%;">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 40%;"><strong>Net Weight</strong></td>
                                                            <td style="width: 5%;">:</td>
                                                            <td>{{ formatCurrency($proformaInvoice->net_weight) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Gross Weight</strong></td>
                                                            <td>:</td>
                                                            <td>{{ formatCurrency($proformaInvoice->gross_weight) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Product NCM</strong></td>
                                                            <td>:</td>
                                                            <td>{{ formatNCM($proformaInvoice->product_ncm) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- tabel detail transaction --}}
                            <div class="tabel-detail-transaksi mt-4">
                                <div class="table-responsive pb-2 border-top" style="max-height: 18rem">
                                    <table class="table table-bordered table-hover table-striped table-sm"
                                        id="tableDetailTransaction">
                                        <thead>
                                            <th class="text-center">Item Description</th>
                                            <th class="text-center">Carton(pcs)</th>
                                            <th class="text-center">Inner(pcs)</th>
                                            <th class="text-center">Unit Price(USD/KG)</th>
                                            <th class="text-center">Net Weight(KG)</th>
                                            <th class="text-center">Price Amount(USD)</th>
                                        </thead>
                                        <tbody id="detail-rows" style="font-size: 12px">
                                            @foreach ($detailTransactions as $detailTransaction)
                                                <tr>
                                                    <td><strong>{{ $detailTransaction->detailProduct->name }}
                                                            {{ formatCurrency($detailTransaction->detailProduct->pcs) }} PCS/
                                                            {{ formatCurrency($detailTransaction->qty) }} KG</strong><br>
                                                        {{ $detailTransaction->detailProduct->dimension }}
                                                        {{ $detailTransaction->detailProduct->color }}
                                                        {{ $detailTransaction->detailProduct->type }}</td>
                                                    <td class="carton">{{ formatCurrency($detailTransaction->carton) }}</td>
                                                    <td class="inner">{{ formatCurrency($detailTransaction->inner_qty_carton) }}</td>
                                                    <td>{{ formatHarga($detailTransaction->unit_price) }}</td>
                                                    <td class="net-weight">{{ formatCurrency($detailTransaction->net_weight) }}</td>
                                                    <td class="price-amount">{{ formatCurrency($detailTransaction->price_amount) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr id="totalRow" style="font-weight: bold;">
                                                <td class="text-center">Amount</td>
                                                <td class="text-center bg-danger text-white" id="totalCarton">0</td>
                                                <td class="text-center bg-danger text-white" id="totalInner">0</td>
                                                <td class="text-center bg-danger text-white"></td>
                                                <td class="text-center bg-danger text-white" id="totalNetWeight">0</td>
                                                <td class="text-center bg-danger text-white" id="PriceAmount">0</td>
                                            </tr>
                                            <tr>
                                                <td class="text-end" colspan="5">FREIGHT COST</td>
                                                <td class="text-center">{{ formatCurrency($proformaInvoice->freight_cost) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-end" colspan="5">TOTAL</td>
                                                <td class="text-center bg-danger text-white">{{ formatCurrency($proformaInvoice->total) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{-- akhir tabel detail transaction --}}
                            <!-- Teks total dalam kata -->
                            <div class="mt-3">
                                <div class="text-end">
                                    <p><strong><em>{{ $totalInWords }} USD</em></strong></p>
                                    <p><em>Payment Condition: FOB (Free on Board)</em></p>
                                </div>
                                <div class="mt-7">
                                    <table class="text-center" style="width: auto; float:right">
                                        <tr>
                                            <td>
                                                <p style="font-weight: bold">Approved By</p>
                                            </td>
                                        </tr>
                                        @if ($approved == 1)
                                            <tr>
                                                <td><img src="{{ asset('storage/' . $proformaInvoice->approverUser->signature_url) }}" alt="Signature"
                                                        width="100px" style="margin-bottom: 10px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid black;">
                                                    {{ $proformaInvoice->approverUser->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $proformaInvoice->approverUser->role }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $proformaInvoice->createdBy ? $proformaInvoice->createdBy->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Last Edited By</th>
                                <td>{{ $proformaInvoice->editedBy ? $proformaInvoice->editedBy->name : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $proformaInvoice->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function updateAmounts() {
                var totalCarton = 0;
                var totalInner = 0;
                var totalNetWeight = 0;
                var PriceAmount = 0;
    
                // Iterasi setiap baris untuk mendapatkan nilai total
                $('#tableDetailTransaction tbody tr').each(function() {
                    // Menghapus tanda koma sebelum parseFloat
                    var carton = parseFloat($(this).find('.carton').text().replace(/,/g, '')) || 0;
                    var inner = parseFloat($(this).find('.inner').text().replace(/,/g, '')) || 0;
                    var netWeight = parseFloat($(this).find('.net-weight').text().replace(/,/g, '')) || 0;
                    var price = parseFloat($(this).find('.price-amount').text().replace(/,/g, '')) || 0;
    
                    totalCarton += carton;
                    totalInner += inner;
                    totalNetWeight += netWeight;
                    PriceAmount += price;
                });
    
                // Update nilai total di footer dengan format ribuan
                $('#totalCarton').text(totalCarton.toLocaleString('en-US'));
                $('#totalInner').text(totalInner.toLocaleString('en-US'));
                $('#totalNetWeight').text(totalNetWeight.toLocaleString('en-US'));
                $('#PriceAmount').text(PriceAmount.toLocaleString('en-US'));
            }
            updateAmounts();
        });
    </script>        
@endsection
