@extends('layouts.layout')
@section('title', 'Detail Transaksi')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Detail Transaksi</h3>
                        </div>
                        <div class="card-body">
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

                            {{-- Bagian 1 --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p><strong>Date</strong></p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-5">
                                                    <p>{{ date('F d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p><strong>Code</strong></p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-5">
                                                    <p id="product-code">-</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p><strong>Number</strong></p>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-5">
                                                    <p id="numberDisplay">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-center">
                                    <h1>INVOICE</h1>
                                </div>
                            </div>

                            <!-- Bagian 2: Consignee, Notify, Client -->
                            <div class="row mt-2">
                                <!-- Client Input -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="client">Client</label>
                                        <select name="id_client" class="form-control client" id="client" required>
                                            <option value="">Pilih Client</option>
                                            {{-- @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            data-address="{{ $client->address }}">
                                                            {{ $client->name }}
                                                        </option>
                                                    @endforeach --}}
                                        </select>
                                        <!-- Element to display the address -->
                                        <div id="client-address" style="margin-top: 10px;"></div>
                                    </div>
                                </div>

                                <!-- Notify Input -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="notify">Notify</label>
                                        <input type="text" name="notify" id="notify" class="form-control"
                                            placeholder="Enter notify party" required>
                                    </div>
                                </div>

                                <!-- Consignee Input -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="consignee">Consignee</label>
                                        <select name="id_consignee" class="form-control consignee" id="consignee" required>
                                            <option value="">Pilih Consignee</option>
                                            {{-- @foreach ($consignees as $consignee)
                                                        <option value="{{ $consignee->id }}"
                                                            data-address="{{ $consignee->address }}">
                                                            {{ $consignee->name }}
                                                        </option>
                                                    @endforeach --}}
                                        </select>
                                        <!-- Element to display the address -->
                                        <div id="consignee-address" style="margin-top: 10px;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian 3: Port of Loading, Place of Receipt, Port of Discharge, Place of Delivery -->
                            <div class="row mt-4">
                                <!-- Port of Loading Input -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="port_of_loading">Port of Loading</label>
                                        <input type="text" name="port_of_loading" id="port_of_loading"
                                            class="form-control" placeholder="Enter port of loading" required>
                                    </div>
                                </div>

                                <!-- Place of Receipt Input -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="place_of_receipt">Place of Receipt</label>
                                        <input type="text" name="place_of_receipt" id="place_of_receipt"
                                            class="form-control" placeholder="Enter place of receipt" required>
                                    </div>
                                </div>

                                <!-- Port of Discharge Input -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="port_of_discharge">Port of Discharge</label>
                                        <input type="text" name="port_of_discharge" id="port_of_discharge"
                                            class="form-control" placeholder="Enter port of discharge" required>
                                    </div>
                                </div>

                                <!-- Place of Delivery Input -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="place_of_delivery">Place of Delivery</label>
                                        <input type="text" name="place_of_delivery" id="place_of_delivery"
                                            class="form-control" placeholder="Enter place of delivery" required>
                                    </div>
                                </div>
                            </div>

                            {{-- bagian 4 --}}
                            <div class="group-info mt-4">
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
                                                <select class="form-control product" id="product" name="id_product"
                                                    required>
                                                    <option value="">Pilih Product</option>
                                                    {{-- @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                data-code="{{ $product->code }}"
                                                                data-abbreviation="{{ $product->abbreviation }}">
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach --}}
                                                </select>
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
                                                <select class="form-control commodity" id="commodity" name="id_commodity"
                                                    required>
                                                    <option value="">Pilih Commodity</option>
                                                    {{-- @foreach ($commodities as $commodity)
                                                            <option value="{{ $commodity->id }}">
                                                                {{ $commodity->name }}
                                                            </option>
                                                        @endforeach --}}
                                                </select>
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
                                                <input type="text" name="container" id="container"
                                                    class="form-control" placeholder="Masukkan Container" required>
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
                                                <input type="number" class="form-control net_weight_transaction"
                                                    step="0.01" disabled>
                                                <input type="hidden" id="net_weight_transaction" name="net_weight"
                                                    class="form-control" step="0.01" placeholder="Contoh: 123.45"
                                                    required>
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
                                                <input type="number" id="gross_weight" name="gross_weight"
                                                    class="form-control" step="0.01" placeholder="Contoh: 123.45"
                                                    required>
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
                                                <input type="text" name="payment_term" id="payment_term"
                                                    class="form-control" placeholder="Masukkan Payment term" required>
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
                                                <input type="date" name="stuffing_date" id="stuffing_date"
                                                    class="form-control" required>
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
                                                <input type="text" name="bl_number" id="bl_number"
                                                    class="form-control" placeholder="Masukkan BL Number" required>
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
                                                <input type="text" name="container_number" id="container_number"
                                                    class="form-control" placeholder="Masukkan Container Number" required>
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
                                                <input type="text" name="seal_number" id="seal_number"
                                                    class="form-control" placeholder="Masukkan Seal Number" required>
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
                                                <input type="text" name="product_ncm" id="product_ncm"
                                                    class="form-control" placeholder="Masukkan Product NCM" required>
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
                                            <th class="text-center">Unit Price(USD/KG)</th>
                                            <th class="text-center">Net Weight(KG)</th>
                                            <th class="text-center">Price Amount(USD)</th>
                                        </thead>
                                        <tbody id="detail-rows" style="font-size: 12px">
                                            <tr id="nullDetailTransaction">
                                                <td colspan="7" class="text-center">Tidak ada barang</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr id="totalRow" style="font-weight: bold;">
                                                <td class="text-center">Amount</td>
                                                <td class="text-center" id="totalCarton">0</td>
                                                <td class="text-center" id="totalInner">0</td>
                                                <td class="text-center"></td>
                                                <td class="text-center" id="totalNetWeight">0</td>
                                                <td class="text-center" id="PriceAmount">0</td>
                                            </tr>
                                            <tr id="inputRow">
                                                <td class="text-center" colspan="5"></td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <label for="additionalInput" class="mr-2">Freight Cost
                                                            :</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="freight_cost" name="freight_cost"
                                                            placeholder="Enter Freight Cost" min="0"
                                                            max="99999999.99">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5"></td>
                                                <td class="text-center" id="amount-total-price">
                                                    <div
                                                        class="form-group d-flex align-items-center justify-content-center">
                                                        <label for="total" class="mr-2">Total:</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="total" name="total" style="width: 150px;">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
