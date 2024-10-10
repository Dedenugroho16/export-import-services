@extends('layouts.layout')
@section('title', 'Packing List')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mb-4 mt-4">
                <a href="{{ route('transaction.index') }}" class="btn btn-primary">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    Kembali
                </a>
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
                                        <img src="{{ asset('dist/img/mefita-logo.png') }}" alt="logo" width="60">
                                        <div style="padding-left: 10px;">
                                            <em style="font-size: 60px; font-weight:500;">PT. PSN</em><br>
                                            <p style="font-weight:500; margin: 0;">PRINGGONDANI SETIA NUSANTARA</p>
                                        </div>
                                    </div>
                            
                                    <!-- Kolom Kanan: Detail Informasi -->
                                    <div class="row mb-5 mt-3">
                                        <div>
                                            <table class="table-sm">
                                                <tr>
                                                    <td><strong>Date</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $transaction->date }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Code</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $transaction->code }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Number</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td class="text-end">{{ $transaction->number }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row mt-6 mb-5">
                                <div class="col-md-12 text-center">
                                    <h1>PACKING LIST</h1>
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
                                                {{ $transaction->consignee->name }} <br>
                                                {{ $transaction->consignee->address }} <br>
                                                {{ $transaction->consignee->tel }}
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
                                                {{ $transaction->notify }} <br>
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
                                                {{ $transaction->client->name }} <br>
                                                {{ $transaction->client->address }} <br>
                                                {{ $transaction->client->tel }}
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
                                            <p>{{ $transaction->port_of_loading }}</p>
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
                                            <p>{{ $transaction->place_of_receipt }}</p>
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
                                            <p>{{ $transaction->port_of_discharge }}</p>
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
                                            <p>{{ $transaction->place_of_delivery }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- bagian 4 --}}
                            <div class="group-info mt-6">
                                <div class="row">
                                    <!-- Kolom Sebelah Kiri -->
                                    <div class="col-6">
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Name of Product</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->product->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Name of Commodity</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->commodity->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Container</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->container }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Net Weight</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->net_weight }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Gross Weight</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->gross_weight }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Payment Term</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->payment_term }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kolom Sebelah Kanan -->
                                    <div class="col-6">
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Stuffing Date</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->stuffing_date }}</p>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>BL Number</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->bl_number }}</p>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Container Number</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->container_number }}</p>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Seal Number</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->seal_number }}</p>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <p><strong>Product NCM</strong></p>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span>:</span>
                                            </div>
                                            <div class="col-5">
                                                <p>{{ $transaction->product_ncm }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <th class="text-center">Net Weight(KG)</th>
                                        </thead>
                                        <tbody id="detail-rows" style="font-size: 12px">
                                            @foreach ($detailTransactions as $detailTransaction)
                                                <tr>
                                                    <td>{{ $detailTransaction->detailProduct->name }}</td>
                                                    <td class="carton">{{ $detailTransaction->carton }}</td>
                                                    <td class="inner">{{ $detailTransaction->inner_qty_carton }}</td>
                                                    <td class="net-weight">{{ $detailTransaction->net_weight }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr id="totalRow" style="font-weight: bold;">
                                                <td class="text-center">Amount</td>
                                                <td class="text-center bg-success text-white" id="totalCarton">0</td>
                                                <td class="text-center bg-success text-white" id="totalInner">0</td>
                                                <td class="text-center bg-success text-white" id="totalNetWeight">0</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{-- akhir tabel detail transaction --}}
                            <!-- Teks total dalam kata -->
                            <div class="text-end mt-3">
                                <div class="mt-7">
                                    <p>Approved By</p>
                                    <img src="{{ asset('dist/img/ttd.png') }}" alt="Signature" width="80">
                                    <div>
                                        <p style="display: inline-block;">
                                            <strong>Approver</strong><br>
                                            <u style="width: 100%; display: block; border-bottom: 1px solid black;"></u>
                                        </p>
                                        <p><strong>Director</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    var carton = parseFloat($(this).find('.carton').text()) || 0;
                    var inner = parseFloat($(this).find('.inner').text()) || 0;
                    var netWeight = parseFloat($(this).find('.net-weight').text()) || 0;
                    var price = parseFloat($(this).find('.price-amount').text()) || 0;

                    totalCarton += carton;
                    totalInner += inner;
                    totalNetWeight += netWeight;
                    PriceAmount += price;
                });

                // Update nilai total di footer
                $('#totalCarton').text(totalCarton);
                $('#totalInner').text(totalInner);
                $('#totalNetWeight').text(totalNetWeight);
                $('#PriceAmount').text(PriceAmount);
            }
            updateAmounts();
        });
    </script>
@endsection
