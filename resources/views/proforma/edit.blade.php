@extends('layouts.layout')
@section('title', 'Edit Proforma Invoice')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Edit Proforma Invoice</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
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

                            <form id="formProformaInvoice" method="POST"
                                action="{{ route('proforma.update', $transaction->id) }}">
                                @csrf
                                <input type="date" name="date" id="date" value="{{ $transaction->date }}" hidden>
                                <input type="text" name="code" id="code" value="{{ $transaction->code }}" hidden>
                                <input type="text" name="number" id="number" value="{{ $transaction->number }}"
                                    hidden>
                                <input type="date" name="stuffing_date" id="stuffing_date" hidden>
                                <input type="text" name="bl_number" id="bl_number" hidden>
                                <input type="text" name="container_number" id="container_number" hidden>
                                <input type="text" name="seal_number" id="seal_number" hidden>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">PROFORMA INVOICE</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row mb-3">
                                                            <div class="col-3">
                                                                <p><strong>Set Country</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-5">
                                                                <select style="width: 100%;" id="country" name="country">
                                                                    <option value="{{ $countrySelected->id }}"
                                                                        data-code="{{ $countrySelected->code }}">
                                                                        {{ $countrySelected->name }}
                                                                        ({{ $countrySelected->code }})
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3">
                                                                <p><strong>Date</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>{{ $transaction->date }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-3">
                                                                <p><strong>Code</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <p id="product-code">{{ $transaction->code }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <p><strong>Number</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <p id="numberDisplay">{{ $transaction->number }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1"></div>
                                                    <div class="col-5">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <p><strong>Client</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <select name="id_client" id="client_id"
                                                                            class="form-control select2">
                                                                            <option value="">Pilih Client</option>
                                                                            @foreach ($clients as $client)
                                                                                <option value="{{ $client->id }}"
                                                                                    {{ $transaction->id_client == $client->id ? 'selected' : '' }}>
                                                                                    {{ $client->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" id="selectedClientId"
                                                                            name="selectedClientId"
                                                                            value="{{ $transaction->id_client }}">
                                                                    </div>
                                                                    <span class="error-message" id="selectedClientId_error"
                                                                        style="color: red; display: none;"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-3">
                                                                <p><strong>Perusahaan</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            id="selectedClientCompanyName"
                                                                            placeholder="Pilih Perusahaan Client"
                                                                            value="{{ old('client_company_name', $transaction->clientCompany->company_name ?? '') }}"
                                                                            readonly>
                                                                        <input type="hidden" id="selectedClientCompanyId"
                                                                            name="id_client_company"
                                                                            value="{{ old('id_client_company', $transaction->clientCompany->id ?? '') }}">
                                                                        <div class="btn-group">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-md"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#clientCompanyModal">
                                                                                <i data-feather="search"></i> Cari
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span class="error-message"
                                                                        id="selectedConsigneeId_error"
                                                                        style="color: red; display: none;"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-3">
                                                                <p><strong>Consignee</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            id="selectedConsigneeName"
                                                                            placeholder="Pilih Consignee"
                                                                            value="{{ $transaction->consignee->name }}"
                                                                            readonly>
                                                                        <input type="hidden" id="selectedConsigneeId"
                                                                            name="id_consignee"
                                                                            value="{{ $transaction->id_consignee }}">
                                                                        <div class="btn-group">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-md"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#consigneeModal">
                                                                                <i data-feather="search"></i> Cari
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span class="error-message"
                                                                        id="selectedConsigneeId_error"
                                                                        style="color: red; display: none;"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-3">
                                                                <p><strong>Notify</strong></p>
                                                            </div>
                                                            <div class="col-1 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="text" name="notify"
                                                                    id="notify"class="form-control"
                                                                    placeholder="Enter notify party"
                                                                    value="{{ $transaction->notify }}" required>
                                                                <span class="error-message" id="notify_error"
                                                                    style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-6">
                                                    <!-- Port of Loading Input -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="port_of_loading">Port of Loading</label>
                                                            <input type="text" name="port_of_loading"
                                                                id="port_of_loading" class="form-control"
                                                                placeholder="Enter port of loading"
                                                                value="{{ $transaction->port_of_loading }}" required>
                                                            <span class="error-message" id="port_of_loading_error"
                                                                style="color: red; display: none;"></span>
                                                        </div>
                                                    </div>

                                                    <!-- Place of Receipt Input -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="place_of_receipt">Place of Receipt</label>
                                                            <input type="text" name="place_of_receipt"
                                                                id="place_of_receipt" class="form-control"
                                                                placeholder="Enter place of receipt"
                                                                value="{{ $transaction->place_of_receipt }}" required>
                                                            <span class="error-message" id="place_of_receipt_error"
                                                                style="color: red; display: none;"></span>
                                                        </div>
                                                    </div>

                                                    <!-- Port of Discharge Input -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="port_of_discharge">Port of Discharge</label>
                                                            <input type="text" name="port_of_discharge"
                                                                id="port_of_discharge" class="form-control"
                                                                placeholder="Enter port of discharge"
                                                                value="{{ $transaction->port_of_discharge }}" required>
                                                            <span class="error-message" id="port_of_discharge_error"
                                                                style="color: red; display: none;"></span>
                                                        </div>
                                                    </div>

                                                    <!-- Place of Delivery Input -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="place_of_delivery">Place of Delivery</label>
                                                            <input type="text" name="place_of_delivery"
                                                                id="place_of_delivery" class="form-control"
                                                                placeholder="Enter place of delivery"
                                                                value="{{ $transaction->place_of_delivery }}" required>
                                                            <span class="error-message" id="place_of_delivery_error"
                                                                style="color: red; display: none;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-6">
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
                                                                <div class="d-flex align-items-center">
                                                                    <select style="width: 100%;" id="product"
                                                                        name="id_product">
                                                                        <option value="{{ $productSelected->id }}"
                                                                            data-code="{{ $productSelected->code }}"
                                                                            data-abbreviation="{{ $productSelected->abbreviation }}">
                                                                            {{ $productSelected->name }}
                                                                            ({{ $productSelected->abbreviation }})
                                                                        </option>
                                                                    </select>
                                                                    <input type="hidden" id="old-product"
                                                                        name="id_product"
                                                                        value="{{ $productSelectedID }}">
                                                                    <button id="infoButton"
                                                                        class="btn btn-warning btn-sm ms-2"
                                                                        title="Informasi" style="display: none;">
                                                                        <i class="fas fa-info-circle"></i>
                                                                        <!-- Using Font Awesome icon -->
                                                                    </button>
                                                                </div>
                                                                <span class="error-message" id="product_error"
                                                                    style="color: red; display: none;"></span>
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
                                                                <select class="form-control commodity" id="commodity"
                                                                    name="id_commodity" required>
                                                                    <option value="">Pilih Commodity</option>
                                                                    @foreach ($commodities as $commodity)
                                                                        <option value="{{ $commodity->id }}"
                                                                            {{ $commodity->id == $commoditySelectedID ? 'selected' : '' }}>
                                                                            {{ $commodity->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="error-message" id="commodity_error"
                                                                    style="color: red; display: none;"></span>
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
                                                                    class="form-control" placeholder="Masukkan Container"
                                                                    value="{{ $transaction->container }}" required>
                                                                <span class="error-message" id="container_error"
                                                                    style="color: red; display: none;"></span>
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
                                                                <input type="text" name="payment_term"
                                                                    id="payment_term" class="form-control"
                                                                    placeholder="Masukkan Payment term"
                                                                    value="{{ $transaction->payment_term }}" required>
                                                                <span class="error-message" id="payment_term_error"
                                                                    style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Kolom Sebelah Kanan -->
                                                    <div class="col-6">
                                                        <div class="row mt-2">
                                                            <div class="col-4">
                                                                <p><strong>Net Weight</strong></p>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text"
                                                                    class="form-control net_weight_transaction"
                                                                    step="0.01" readonly>
                                                                <span class="error-message" id="net_weight_error"
                                                                    style="color: red; display: none;"></span>
                                                                <input type="hidden" id="net_weight_transaction"
                                                                    name="net_weight" class="form-control" step="0.01"
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
                                                                <input type="text" id="gross_weight_display"
                                                                    class="form-control"
                                                                    value="{{ number_format($transaction->gross_weight, 0, ',', ',') }}"
                                                                    required>
                                                                <input type="hidden" id="gross_weight"
                                                                    name="gross_weight">
                                                                <span class="error-message" id="gross_weight_error"
                                                                    style="color: red; display: none;"></span>
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
                                                                    class="form-control"
                                                                    value="{{ $transaction->product_ncm }}" required>
                                                                <span class="error-message" id="product_ncm_error"
                                                                    style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-4">
                                                                <p><strong>Payment Condition</strong></p>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text" name="payment_condition"
                                                                    id="payment_condition" class="form-control"
                                                                    value="{{ $transaction->payment_condition }}"
                                                                    required>
                                                                <span class="error-message" id="payment_condition_error"
                                                                    style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- tabel detail transaction --}}
                                <div class="card mt-3 mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4>Transaction Details</h4>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#memberModal">
                                                <i data-feather="search"></i> Cari Detail Produk
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p id="error-message-qty" style="color: red; display:none">Nilai maksimum QTY
                                            adalah tiga digit
                                        </p>
                                        <p id="error-message-carton" style="color: red; display:none">Nilai maksimum
                                            Carton adalah
                                            enam digit</p>
                                        <div class="table-responsive pb-2 border-top">
                                            <table class="table table-bordered table-hover table-striped table-sm"
                                                id="tableDetailTransaction">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Item Description</th>
                                                        <th class="text-center">Carton(pcs)</th>
                                                        <th class="text-center">Inner(pcs)</th>
                                                        <th class="text-center">Unit Price (USD/KG)</th>
                                                        <th class="text-center">Net Weight (KG)</th>
                                                        <th class="text-center">Price Amount (USD)</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>

                                                <!-- Tbody untuk data yang berasal dari fungsi load -->
                                                <tbody id="loadedData" style="font-size: 12px">
                                                    <tr id="nullDetailTransaction">
                                                        <td colspan="8" class="text-center">Tidak ada barang</td>
                                                    </tr>
                                                </tbody>

                                                <!-- Tbody untuk data yang berasal dari tombol pilih -->
                                                <tbody id="selectedData" style="font-size: 12px">
                                                </tbody>

                                                <tfoot>
                                                    <tr id="totalRow" style="font-weight: bold;">
                                                        <td class="text-center" colspan="1">Amount</td>
                                                        <td class="text-center" id="totalCarton">0</td>
                                                        <td class="text-center" id="totalInner">0</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center" id="totalNetWeight">0</td>
                                                        <td class="text-center" id="PriceAmount">0</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="inputRow">
                                                        <td class="text-end" colspan="5"><label for="additionalInput"
                                                                class="mr-2">Freight Cost
                                                                :</label></td>
                                                        <td class="text-center">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <input type="text" step="0.01" class="form-control"
                                                                    id="freight_cost_display" name="freight_cost_display"
                                                                    value="{{ number_format($transaction->freight_cost, 0, ',', ',') }}"
                                                                    placeholder="Enter Freight Cost" min="0"
                                                                    max="99999999.99">
                                                                <input type="hidden" step="0.01" class="form-control"
                                                                    id="freight_cost" name="freight_cost"
                                                                    placeholder="Enter Freight Cost" min="0"
                                                                    max="99999999.99">
                                                            </div>
                                                            <span class="error-message" id="freight_cost_error"
                                                                style="color: red; display: none;"></span>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end" colspan="5">Total :</td>
                                                        <td class="text-center" id="amount-total-price">
                                                            <div
                                                                class="form-group d-flex align-items-center justify-content-center">
                                                                <input type="text" step="0.01"
                                                                    class="form-control total-display" readonly>
                                                                <input type="hidden" step="0.01" class="form-control"
                                                                    id="total" name="total" style="width: 150px;">
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form id="formDetailTransaction" method="POST"
                                action="{{ route('detail-transaction.update', $transaction->id) }}">
                                @csrf
                                <!-- Hidden inputs will be generated here -->
                            </form>

                            <form id="newFormDetailTransaction" method="POST"
                                action="{{ route('detailtransaction.store') }}">
                                @csrf
                                <!-- Hidden inputs will be generated here -->
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <p id="error-message" style="color: red;">Harap menginput negara terlebih
                                    dahulu</p>
                                <a href="{{ route('proforma.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal Perusahaan Client --}}
    <div class="modal fade text-left" id="clientCompanyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Pilih Perusahaan Client</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table card-table table-vcenter text-nowrap" id="clientCompanyModalTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">PO BOX</th>
                                <th class="text-center">Telepon</th>
                                <th class="text-center">Fax</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- server side data --}}
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="consigneeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h5 class="modal-title" id="consigneeModalLabel">Pilih Consignee</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table card-table table-vcenter text-nowrap" id="consigneeModalTable">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Telepon</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="nullConsignee">
                                <td colspan="8" class="text-center">Harap pilih client terlebih dahulu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="memberModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Detail Produk</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-2 mt-1">Data Detail Produk</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="detailProductTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah (pcs)</th>
                                            <th>Dimensi</th>
                                            <th>Tipe</th>
                                            <th>Warna</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Fungsi untuk memformat angka dalam format dolar
            function formatDollar(angka) {
                let parts = angka.split('.');
                let sisa = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                return parts[1] !== undefined ? sisa + '.' + parts[1] : sisa;
            }

            // Ambil elemen input untuk Gross Weight
            const grossWeightDisplay = document.getElementById('gross_weight_display');
            const grossWeight = document.getElementById('gross_weight');

            // Sinkronisasi awal ketika halaman pertama kali dimuat
            let initialValue = grossWeightDisplay.value.replace(/[^0-9.]/g, '');
            grossWeight.value = initialValue;

            // Event listener untuk memformat input saat user mengetik (Gross Weight)
            grossWeightDisplay.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^0-9.]/g, '');
                grossWeight.value = value; // Perbarui nilai di input hidden tanpa format
                e.target.value = formatDollar(value); // Tampilkan nilai terformat di display
            });

            // Bagian untuk freight cost
            const freightCostDisplay = document.getElementById('freight_cost_display');
            const freightCost = document.getElementById('freight_cost');

            // Sinkronisasi awal ketika halaman pertama kali dimuat
            let initialValueFC = freightCostDisplay.value.replace(/[^0-9.]/g, '');
            freightCost.value = initialValueFC;

            freightCostDisplay.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^.\d]/g, '');
                freightCost.value = value;
                e.target.value = formatDollar(value);
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#country').select2({
                ajax: {
                    url: '/ajax-countries',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Search term for countries
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(country) {
                                return {
                                    id: country.id,
                                    text: country.text + ' (' + country.code + ')',
                                    code: country.code
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: "Select a country",
            });

            // Initialize Select2 for client
            $(document).ready(function() {
                $('#client_id').select2({
                    placeholder: "Pilih Client",
                    width: '100%',
                    ajax: {
                        url: '{{ route('proforma.clients.select2') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term // Search query
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    }
                });
            });

            // Initialize Select2 for products
            $('#product').select2({
                placeholder: "Pilih Product",
                ajax: {
                    url: '/ajax-products',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Search term for products
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(product) {
                                return {
                                    id: product.id,
                                    text: product.text,
                                    code: product.code,
                                    abbreviation: product.abbreviation
                                };
                            })
                        };
                    },
                    cache: true
                },
                templateResult: function(product) {
                    // Display product name with abbreviation in the search results
                    if (product.loading) return product.text;
                    return $('<span>' + product.text + ' (' + product.abbreviation + ')</span>');
                },
                templateSelection: function(product) {
                    if (!product.id) {
                        return $('<span>Pilih produk</span>');
                    }
                    if (!product.abbreviation) {
                        return $('<span>' + product.text + '</span>');
                    }
                    // Display name and code in the selected option
                    return $('<span>' + product.text + ' (' + product.abbreviation + ')</span>');
                }
            });

            // Function to set the selected country in Select2
            function setSelectedCountry() {
                if ({{ isset($countrySelected) ? 'true' : 'false' }}) {
                    $('#country').select2('data', [{
                        id: '{{ $countrySelected->id }}',
                        text: '{{ $countrySelected->name }} ({{ $countrySelected->code }})',
                        code: '{{ $countrySelected->code }}'
                    }]);
                }
            }

            // Function to set the selected product in Select2
            function setSelectedProduct() {
                if ({{ isset($productSelected) ? 'true' : 'false' }}) {
                    $('#product').select2('data', [{
                        id: '{{ $productSelected->id }}',
                        text: '{{ $productSelected->name }} ({{ $productSelected->code }})',
                        code: '{{ $productSelected->code }}',
                        abbreviation: '{{ $productSelected->abbreviation }}' // If you have this property
                    }]);
                }
            }

            // Call the functions to set the selected values
            setSelectedCountry();
            setSelectedProduct();

            $('#commodity').select2({
                placeholder: "Pilih Commodity",
                ajax: {
                    url: '/ajax-commodities',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });

        // modal datatables
        $(document).ready(function() {
            // Saat halaman dimuat, tombol "Tambah" dinonaktifkan
            if ($('#country').val() === '') {
                $('#submitButton').prop('disabled', true);
            } else {
                $('#submitButton').prop('disabled', false);
                $('#error-message').hide();
            }


            // Deteksi perubahan pada dropdown negara
            $('#country').on('change', function() {
                // Ambil value yang dipilih
                var selectedValue = $(this).val();

                if (selectedValue === "") {
                    // Jika belum ada negara yang dipilih, tombol "Tambah" dinonaktifkan
                    $('#submitButton').prop('disabled', true);
                    $('#error-message').show();
                } else {
                    // Jika negara sudah dipilih, tombol "Tambah" diaktifkan
                    $('#submitButton').prop('disabled', false);
                    // Sembunyikan pesan error
                    $('#error-message').hide();
                }
            });

            // Initialize DataTable
            var table = $('#detailProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('edit-get-detail-products') }}",
                    data: function(d) {
                        var productId = $('#product').val();
                        d.id_product = productId ? productId : null;
                    }
                },
                columns: [{
                        data: null,
                        name: 'no',
                        title: "No",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: "Nama Produk"
                    },
                    {
                        data: 'pcs',
                        name: 'pcs',
                        title: "Jumlah (pcs)"
                    },
                    {
                        data: 'dimension',
                        name: 'dimension',
                        title: "Dimensi"
                    },
                    {
                        data: 'type',
                        name: 'type',
                        title: "Tipe"
                    },
                    {
                        data: 'color',
                        name: 'color',
                        title: "Warna"
                    },
                    {
                        data: 'price',
                        name: 'price',
                        title: "Harga"
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<button class="btn btn-primary btn-sm pilih-btn">Pilih</button>`;
                        }
                    }
                ],
                language: {
                    decimal: ",",
                    thousands: ".",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    loadingRecords: "Sedang memuat...",
                    processing: "Sedang memproses...",
                    emptyTable: function() {
                        var productSelected = $('#product').val();
                        return productSelected ?
                            "Produk yang Anda pilih tidak memiliki detail produk" :
                            "Tolong pilih produk terlebih dahulu";
                    }
                },
                responsive: true,
                autoWidth: false,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10
            });

            // Event ketika user memilih produk
            $('#product').change(function() {
                if ($(this).val()) {
                    table.ajax.reload(); // Reload DataTables dengan data produk yang dipilih
                } else {
                    table.clear().draw(); // Kosongkan tabel jika tidak ada produk yang dipilih
                }
            });

            // event untuk code transaksi
            // Fungsi untuk mendapatkan dua digit bulan dan dua digit tahun dari tanggal saat ini
            function getTwoDigitYearMonth() {
                var date = new Date();
                var year = date.getFullYear().toString().slice(-2); // Mengambil dua digit terakhir dari tahun
                var month = ("0" + (date.getMonth() + 1)).slice(-2); // Mengambil dua digit bulan
                return year + month; // Menggabungkan dua digit tahun dan dua digit bulan
            }

            // Function to update product code based on selected country and product
            function updateProductCode() {
                let countryCode;
                const selectedOption = $('#country option:selected');
                if (selectedOption && selectedOption.data('code') === "{{ $countrySelected->code }}") {
                    const selectedOption = $('#country option:selected');
                    countryCode = selectedOption.data('code'); // Ambil data-code untuk Indonesia
                } else {
                    const countryData = $('#country').select2('data')[0];
                    countryCode = countryData ? countryData.code : null; // Ambil kode negara dari data Select2
                }

                let productCode;
                const selectedProductOption = $('#product option:selected');
                if (selectedProductOption && selectedProductOption.data('code') ===
                    "{{ $productSelected->code }}") {
                    productCode = selectedProductOption.data('code');
                } else {
                    const productData = $('#product').select2('data')[0];
                    productCode = productData ? productData.code : null;
                }

                const twoDigitYearMonth = getTwoDigitYearMonth();

                let codeText = '-';
                if (productCode && countryCode) {
                    codeText = `${productCode} ${countryCode}${twoDigitYearMonth}`;
                } else if (productCode) {
                    codeText = `${productCode} pilih negara! ${twoDigitYearMonth}`;
                } else if (countryCode) {
                    codeText = `${countryCode}${twoDigitYearMonth}`;
                }

                $('#product-code').text(codeText);
                $('#code').val(codeText); // Set the input value with the final product code
            }

            function updateNumber() {
                let countryCode;
                const selectedCountryOption = $('#country').find(':selected');

                // Ambil data kode negara
                if (selectedCountryOption && selectedCountryOption.data('code') ===
                    "{{ $countrySelected->code }}") {
                    countryCode = selectedCountryOption.data('code');
                } else {
                    const countryData = $('#country').select2('data');
                    countryCode = countryData.length ? countryData[0].code : null;
                }

                let productAbbreviation;
                const selectedProductOption = $('#product').find(':selected');

                // Ambil data kode produk
                if (selectedProductOption && selectedProductOption.data('abbreviation') ===
                    "{{ $productSelected->abbreviation }}") {
                    productAbbreviation = selectedProductOption.data('abbreviation');
                } else {
                    const productData = $('#product').select2('data');
                    productAbbreviation = productData.length ? productData[0].abbreviation : null;
                }

                const currentDate = new Date();
                const twoDigitMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                const romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                const romanMonth = romanMonths[currentDate.getMonth()];
                const twoDigitYear = currentDate.getFullYear().toString().slice(-2);

                // Format nomor sesuai template
                const formattedNumber =
                    `${countryCode ? countryCode + '/' : ''}${twoDigitMonth}/INV/${romanMonth}/${twoDigitYear}`;

                let finalNumber;
                if (productAbbreviation) {
                    finalNumber = `{{ $formattedNumber }}.${productAbbreviation} ${formattedNumber}`;
                } else {
                    finalNumber = `{{ $formattedNumber }} ${formattedNumber}`;
                }

                // Tampilkan dan simpan nomor yang dihasilkan
                $('#numberDisplay').text(finalNumber);
                $('#number').val(finalNumber);
            }

            // Pantau perubahan pada dropdown product dan country untuk memperbarui kode
            $('#product, #country').on('change', function() {
                updateProductCode();
                updateNumber();
            });

            // Jalankan fungsi updateProductCode saat halaman dimuat untuk menginisialisasi
            updateProductCode();
            updateNumber();

            function confirmDelete(deleteUrl, idTransaction) {
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // Sertakan CSRF token
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', 'Data telah dihapus.', 'success');
                                loadDetailTransaction(idTransaction);
                                updateFormDetailTransaction();
                                updateSelectedProductIds(idTransaction);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                    'error');
                                console.error(xhr
                                    .responseText); // Log untuk melihat kesalahan lebih rinci
                            }
                        });
                    }
                });
            }

            function loadDetailTransaction(idTransaction) {
                $.ajax({
                    url: `/get-detail-transaction/${idTransaction}`,
                    method: 'GET',
                    success: function(response) {
                        $('#loadedData').empty(); // Kosongkan tbody khusus untuk data loaded

                        if (response.length > 0) {
                            response.forEach(function(data) {
                                let qty = parseFloat(data.qty || 0);
                                let formattedQty = qty.toLocaleString('en-US');

                                let carton = parseFloat(data.carton || 0);
                                let formattedCarton = carton.toLocaleString('en-US');

                                let innerQtyCarton = parseFloat(data.inner_qty_carton || 0);
                                let formattedInnerQtyCarton = innerQtyCarton.toLocaleString(
                                    'en-US');

                                let netWeight = parseFloat(data.net_weight || 0);
                                let formattedNetWeight = innerQtyCarton.toLocaleString('en-US');

                                let priceAmount = parseFloat(data.price_amount || 0);
                                let formattedPriceAmount = priceAmount.toLocaleString('en-US');

                                var deleteUrl =
                                    `/detail-transaction/delete/${data.detail_transaction_id}/${data.id_detail_product}`;

                                var newRow = `
                        <tr>
                            <td class="text-center id-detail-transaction" style="display: none;">${data.id}</td>
                            <td class="text-center id-detail-product" style="display: none;">${data.id_detail_product}</td>
                            <td class="text-center">
                                <strong>${data.product_name} ${data.pcs} PCS / 
                                <input type="text" class="form-control qty-input" style="width: 70px; display: inline-block;" placeholder="Qty" min="1" value="${formattedQty}" /> KG</strong><br>
                                ${data.dimension} ${data.color} - ${data.type}
                            </td>
                            <td class="text-center"><input type="text" class="form-control carton-input" style="width: 100px; display: inline-block;" min="1" value="${formattedCarton}" /></td>
                            <td class="text-center inner-result">${formattedInnerQtyCarton}</td>
                            <td class="text-center price" data-price="${data.unit_price}">${data.unit_price}</td>
                            <td class="text-center net-weight">${formattedNetWeight}</td>
                            <td class="text-center price-result">${formattedPriceAmount}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm old-remove-btn" data-url="${deleteUrl}">Hapus</button>
                            </td>
                        </tr>
                    `;
                                $('#loadedData').append(newRow);
                            });

                            // Disable the select element
                            $('#product').prop('disabled', true);
                            $('#old-product').prop('disabled', false);
                            $('#infoButton').show();

                            // Event listener untuk tombol hapus
                            $('#loadedData').on('click', '.old-remove-btn', function() {
                                var deleteUrl = $(this).data('url');
                                confirmDelete(deleteUrl, idTransaction);
                            });

                            addDynamicEventListeners();
                            updateAmounts();
                        } else {
                            // Disable the select element
                            $('#product').prop('disabled', false);
                            $('#old-product').prop('disabled', true);
                            $('#infoButton').hide();
                            $('#loadedData').append(`
                    <tr id="nullDetailTransaction">
                        <td colspan="8" class="text-center">Seluruh detail transaksi yang tersimpan terhapus!</td>
                    </tr>
                `);
                        }

                        updateFormDetailTransaction();
                        updateAmounts();
                        updateTotals();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching detail transactions:', error);
                    }
                });
            }

            // Optional: Handle click on info button to show the alert
            $('#infoButton').on('click', function(event) {
                event.preventDefault(); // Prevent default action (just in case)
                Swal.fire({
                    title: 'Informasi!',
                    text: 'Kosongkan detail transaksi sebelumnya untuk mengganti produk.',
                    icon: 'info',
                    showCloseButton: true,
                    confirmButtonText: 'Tutup',
                });
            });

            function addDynamicEventListeners() {
                // Event listener for qty and carton input changes in #loadedData (related to formDetailTransaction)
                $('#loadedData').on('input', '.qty-input, .carton-input', function() {
                    var row = $(this).closest('tr'); // Get the row where the input is located
                    var qty = parseFloat(row.find('.qty-input').val().replace(/,/g, '')) ||
                        0; // Get qty value
                    var carton = parseFloat(row.find('.carton-input').val().replace(/,/g, '')) ||
                        0; // Get carton value
                    var unitPrice = parseFloat(row.find('.price').data('price')) ||
                        0; // Get unit price from data attribute

                    // Batas maksimum untuk qty dan carton
                    var maxQty = 999; // Maksimum 3 digit
                    var maxCarton = 999999; // Maksimum 4 digit

                    // Flag to track if input exceeds limits
                    var exceedsLimit = false;

                    // Check if qty exceeds max value
                    if (qty > maxQty) {
                        $('#error-message-qty').show();
                        exceedsLimit = true;
                    } else {
                        $('#error-message-qty').hide();
                    }

                    // Check if carton exceeds max value
                    if (carton > maxCarton) {
                        $('#error-message-carton').show();
                        exceedsLimit = true;
                    } else {
                        $('#error-message-carton').hide();
                    }

                    // Jika ada yang melebihi batas, disable tombol submit
                    if (exceedsLimit) {
                        $('#submitButton').prop('disabled', true);
                    } else {
                        $('#submitButton').prop('disabled', false);
                    }

                    // Perform calculations based on qty and carton
                    var innerResult = qty * carton; // Example logic, adjust as needed
                    var formattedInnerResult = innerResult.toLocaleString('en-US');
                    var totalPrice = innerResult *
                        unitPrice; // Calculate total price based on result and unit price
                    var rounded = Math.round(totalPrice);
                    var formattedTotalPrice = rounded.toLocaleString('en-US');
                    var formattedCartonInput = carton.toLocaleString('en-US');
                    var formattedQty = qty.toLocaleString('en-US');


                    // Update the relevant columns in the row
                    row.find('.inner-result').text(formattedInnerResult); // Update inner result
                    row.find('.net-weight').text(formattedInnerResult); // Update net weight
                    row.find('.price-result').text(formattedTotalPrice); // Update total price (rounded)
                    row.find('.carton-input').val(formattedCartonInput); // Update total price (rounded)
                    row.find('.qty-input').val(formattedQty); // Update total price (rounded)

                    // Update total amounts and form for loadedData
                    updateAmounts();
                    updateTotals();
                    updateFormDetailTransaction(); // Ensure this only updates formDetailTransaction
                });
            }

            function updateFormDetailTransaction() {
                // Periksa apakah tabel di dalam #loadedData kosong atau hanya mengandung baris 'Tidak ada barang'
                if ($('#loadedData tr').length === 0 || $('#loadedData #nullDetailTransaction').length > 0) {
                    // Kosongkan form jika tidak ada baris produk yang valid
                    $('#formDetailTransaction').empty();
                    return;
                }

                $('#formDetailTransaction').empty();

                // Tambahkan hidden input untuk id transaksi
                $('#formDetailTransaction').append(`
        <input type="hidden" name="id_transaction" id="id_transaction" value="{{ $transaction->id }}">
    `);

                // Selektor untuk setiap baris di tbody #loadedData
                $('#tableDetailTransaction #loadedData tr').each(function(index, row) {
                    // Skip the row if it is the 'No data' row
                    if ($(row).attr('id') === 'nullDetailTransaction') return;

                    var idDetailTransaction = $(row).find('.id-detail-transaction').text()
                        .trim(); // Ambil ID Detail Transaction
                    var idDetailProduct = $(row).find('.id-detail-product').text().trim();
                    var qty = $(row).find('.qty-input').val();
                    var carton = $(row).find('.carton-input').val().replace(/,/g, '');
                    var inner = $(row).find('.inner-result').text().trim().replace(/,/g, '');
                    var unitPrice = $(row).find('.price').text().trim();
                    var netWeight = $(row).find('.net-weight').text().trim().replace(/,/g, '');
                    var priceAmount = $(row).find('.price-result').text().trim().replace(/,/g, '');

                    // Create hidden inputs and append to the form
                    $('#formDetailTransaction').append(`
            <input type="hidden" name="transactions[${index}][id]" value="${idDetailTransaction}"> <!-- Tambahkan ID Detail Transaction -->
            <input type="hidden" name="transactions[${index}][id_detail_product]" value="${idDetailProduct}">
            <input type="hidden" name="transactions[${index}][qty]" value="${qty}">
            <input type="hidden" name="transactions[${index}][carton]" value="${carton}">
            <input type="hidden" name="transactions[${index}][inner_qty_carton]" value="${inner}">
            <input type="hidden" name="transactions[${index}][unit_price]" value="${unitPrice}">
            <input type="hidden" name="transactions[${index}][net_weight]" value="${netWeight}">
            <input type="hidden" name="transactions[${index}][price_amount]" value="${priceAmount}">
        `);

                    // Mark this row as processed
                    $(row).attr('data-processed', 'true');
                });
            }

            // Panggil fungsi untuk memuat detail transaksi ketika halaman dimuat
            var transactionId = "{{ $transaction->id }}"; // Ambil id_transaction dari backend
            if (transactionId) {
                loadDetailTransaction(transactionId);
            }

            // Fungsi untuk memperbarui total nilai
            function updateAmounts() {
                var totalCarton = 0;
                var totalInner = 0;
                var totalNetWeight = 0;
                var totalPriceAmount = 0;

                // Fungsi untuk menghitung total dari tbody tertentu
                function calculateTotals(tbody) {
                    tbody.find('tr').each(function() {
                        var carton = parseFloat($(this).find('.carton-input').val().replace(/,/g, '')) || 0;
                        var inner = parseFloat($(this).find('.inner-result').text().replace(/,/g, '')) || 0;
                        var netWeight = parseFloat($(this).find('.net-weight').text().replace(/,/g, '')) ||
                            0;
                        var price = parseFloat($(this).find('.price-result').text().replace(/,/g, '')) || 0;

                        totalCarton += carton;
                        totalInner += inner;
                        totalNetWeight += netWeight;
                        totalPriceAmount += price;
                    });
                }

                // Hitung total dari #loadedData
                calculateTotals($('#loadedData'));

                // Hitung total dari #selectedData
                calculateTotals($('#selectedData'));

                // Format hasil perhitungan dengan pemisah ribuan en-US
                var formattedTotalCarton = totalCarton.toLocaleString('en-US');
                var formattedTotalInner = totalInner.toLocaleString('en-US');
                var formattedTotalNetWeight = totalNetWeight.toLocaleString('en-US');
                var formattedPriceAmount = totalPriceAmount.toLocaleString('en-US');

                // Update nilai total di footer (tfoot)
                $('#totalCarton').text(formattedTotalCarton);
                $('#totalInner').text(formattedTotalInner);
                $('#totalNetWeight').text(formattedTotalNetWeight);
                $('#PriceAmount').text(formattedPriceAmount);

                // Update nilai hidden input untuk form pengiriman atau data lainnya
                $('#net_weight_transaction').val(totalNetWeight);
                $('.net_weight_transaction').val(formattedTotalNetWeight);
            }

            // Fungsi untuk memperbarui total price amount
            function updateTotals() {
                // Ambil nilai dari Price Amount yang ada di kolom
                var priceAmount = parseFloat($('#PriceAmount').text().replace(/,/g, '')) || 0;

                // Ambil nilai dari input Freight Cost
                var freightCost = parseFloat($('#freight_cost_display').val().replace(/,/g, '')) || 0;

                // Hitung total dengan menambahkan priceAmount dan freightCost
                var total = priceAmount + freightCost;

                // Update elemen dengan total baru
                var formattedGrandTotal = total.toLocaleString('en-US');
                $('.total-display').val(formattedGrandTotal);
                $('#total').val(total);
            }

            // Event listener untuk input Freight Cost
            $('#freight_cost_display').on('input', function() {
                updateTotals();
            });

            // Event handler ketika tombol "Pilih" diklik
            // Fungsi untuk memperbarui form detail transaksi
            function newUpdateFormDetailTransaction() {
                // Filter hanya baris yang memiliki atribut 'data-from-process' true
                var validRows = $('#selectedData tr').filter(function() {
                    return $(this).attr('data-from-process') === 'true';
                });

                // Jika tidak ada baris valid, kosongkan form dan return agar tidak mengirim
                if (validRows.length === 0) {
                    $('#newFormDetailTransaction').empty();
                    return; // Tidak ada data baru yang valid, tidak perlu melanjutkan
                }

                // Kosongkan form sebelum menambahkan input baru
                $('#newFormDetailTransaction').empty();

                // Tambahkan hidden input untuk id transaksi (hanya jika ada data valid)
                $('#newFormDetailTransaction').append(`
        <input type="hidden" name="id_transaction" id="id_transaction" value="{{ $transaction->id }}">
    `);

                // Loop untuk setiap baris valid dan tambahkan input hidden untuk data transaksi baru
                validRows.each(function(index, row) {
                    var idDetailProduct = $(row).find('.id-detail-product').text().trim();
                    var qty = $(row).find('.qty-input').val().replace(/,/g, '');
                    var carton = $(row).find('.carton-input').val().replace(/,/g, '');
                    var inner = $(row).find('.inner-result').text().trim().replace(/,/g, '');
                    var unitPrice = $(row).find('.price').text().trim().replace(/,/g, '');
                    var netWeight = $(row).find('.net-weight').text().trim().replace(/,/g, '');
                    var priceAmount = $(row).find('.price-result').text().trim().replace(/,/g, '');

                    // Append hidden inputs untuk setiap transaksi baru
                    $('#newFormDetailTransaction').append(`
            <input type="hidden" name="transactions[${index}][id_detail_product]" value="${idDetailProduct}">
            <input type="hidden" name="transactions[${index}][qty]" value="${qty}">
            <input type="hidden" name="transactions[${index}][carton]" value="${carton}">
            <input type="hidden" name="transactions[${index}][inner_qty_carton]" value="${inner}">
            <input type="hidden" name="transactions[${index}][unit_price]" value="${unitPrice}">
            <input type="hidden" name="transactions[${index}][net_weight]" value="${netWeight}">
            <input type="hidden" name="transactions[${index}][price_amount]" value="${priceAmount}">
        `);
                });
            }

            // Inisialisasi array selectedProductIds dengan data dari server
            var selectedProductIds = @json($selectedProductIds);

            function updateSelectedProductIds(transactionId) {
                $.ajax({
                    url: '/get-selected-product-ids/' + transactionId, // Menggunakan ID di URL
                    type: 'GET',
                    success: function(response) {
                        // Update array selectedProductIds dengan data baru dari server
                        selectedProductIds = response.selectedProductIds;

                        console.log('Selected Product IDs updated: ',
                            selectedProductIds); // Untuk debugging
                    },
                    error: function() {
                        console.log('Failed to update selectedProductIds');
                    }
                });
            }
            var newSelectedProductIds = []; // Produk baru yang dipilih dalam sesi ini

            // pilih button modal
            $('#detailProductTable tbody').on('click', '.pilih-btn', function() {
                var data = table.row($(this).parents('tr'))
                    .data();

                if (selectedProductIds.includes(data.id) || newSelectedProductIds.includes(data.id)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Produk sudah dipilih',
                        text: 'Detail product ini sudah dipilih. Silakan pilih produk lain.',
                        confirmButtonText: 'OK'
                    });
                    $('#memberModal').modal('hide');
                    return;
                }

                $('#nullDetailTransaction').remove();

                // Membuat elemen tr untuk ditambahkan ke tbody #selectedData
                var newRow = `
        <tr data-from-process="true"> <!-- Tambahkan atribut penanda -->
            <td class="text-center id-detail-product" style="display: none;">${data.id}</td>
            <td class="text-center">
                <strong>${data.name} ${data.pcs} PCS / 
                <input type="text" class="form-control qty-input" style="width: 70px; display: inline-block;" placeholder="Qty" min="1" /> KG</strong><br>
                ${data.dimension} ${data.color} - ${data.type}
                <input type="hidden" class="qty_input" name="qty_input">
            </td>
            <td class="text-center">
                <input type="text" class="form-control carton-input" style="width: 100px; display: inline-block;" placeholder="Carton" min="1" />
                <input type="hidden" class="carton_input" name="carton_input">
                </td>
            <td class="text-center inner-result">0</td>
            <td class="text-center price">${data.price}</td>
            <td class="text-center net-weight">0</td>
            <td class="text-center price-result">0</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm remove-btn">Hapus</button>
            </td>
        </tr>
    `;

                // Tambahkan produk baru ke array newSelectedProductIds
                newSelectedProductIds.push(data.id);

                // Menambahkan elemen tr baru ke tbody #selectedData
                $('#selectedData').append(newRow);

                // Menghapus baris "Tidak ada barang" di tbody #selectedData jika ada
                $('#nullDetailTransaction').remove();

                $(document).on('input', '.carton-input', function(e) {
                    // Ambil nilai yang dimasukkan pengguna dan hilangkan karakter yang tidak diinginkan
                    let value = e.target.value.replace(/[^.\d]/g, '');

                    // Temukan input hidden terkait di dalam elemen yang sama
                    let hiddenInput = $(this).closest('td').find('.carton_input');

                    // Set nilai pada input hidden tanpa koma
                    hiddenInput.val(value.replace(/,/g, ''));

                    // Format nilai yang terlihat dengan pemisah ribuan
                    e.target.value = formatCarton(value);

                    // Fungsi untuk memformat angka dengan pemisah ribuan dan titik desimal
                    function formatCarton(angka) {
                        let parts = angka.split('.');
                        let sisa = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        return parts[1] !== undefined ? sisa + '.' + parts[1] : sisa;
                    }
                });

                $(document).on('input', '.qty-input', function(e) {
                    // Ambil nilai yang dimasukkan pengguna dan hilangkan karakter yang tidak diinginkan
                    let valueQty = e.target.value.replace(/[^.\d]/g, '');

                    // Temukan input hidden terkait di dalam elemen yang sama
                    let hiddenQtyInput = $(this).closest('td').find('.qty_input');

                    // Set nilai pada input hidden tanpa koma
                    hiddenQtyInput.val(valueQty.replace(/,/g, ''));

                    // Format nilai yang terlihat dengan pemisah ribuan
                    e.target.value = formatCarton(valueQty);

                    // Fungsi untuk memformat angka dengan pemisah ribuan dan titik desimal
                    function formatCarton(angka) {
                        let parts = angka.split('.');
                        let sisa = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        return parts[1] !== undefined ? sisa + '.' + parts[1] : sisa;
                    }
                });

                // Event listener to calculate the result on input change
                $('#selectedData').on('input', '.qty-input, .carton-input', function() {
                    var row = $(this).closest('tr');
                    var qty = parseFloat(row.find('.qty-input').val().replace(/,/g, '')) || 0;
                    var carton = parseFloat(row.find('.carton-input').val().replace(/,/g, '')) || 0;
                    var price = parseFloat(row.find('.price').text().replace(/,/g, '')) || 0;

                    // Batas maksimum untuk qty dan carton
                    var maxQty = 999; // Maksimum 3 digit
                    var maxCarton = 999999; // Maksimum 4 digit

                    // Flag to track if input exceeds limits
                    var exceedsLimit = false;

                    // Check if qty exceeds max value
                    if (qty > maxQty) {
                        $('#error-message-qty').show();
                        exceedsLimit = true;
                    } else {
                        $('#error-message-qty').hide();
                    }

                    // Check if carton exceeds max value
                    if (carton > maxCarton) {
                        $('#error-message-carton').show();
                        exceedsLimit = true;
                    } else {
                        $('#error-message-carton').hide();
                    }

                    // Jika ada yang melebihi batas, disable tombol submit
                    if (exceedsLimit) {
                        $('#submitButton').prop('disabled', true);
                    } else {
                        $('#submitButton').prop('disabled', false);
                    }

                    // Multiply qty by carton and update the result
                    var result = qty * carton;
                    var formattedResult = result.toLocaleString('en-US');
                    row.find('.inner-result').text(formattedResult);
                    row.find('.net-weight').text(formattedResult);

                    // Update the price based on result * data.price
                    var totalPrice = result * price;
                    var roundedPrice = Math.round(
                        totalPrice); // Round the total price to nearest integer
                    var formattedRoundedPrice = roundedPrice.toLocaleString('en-US');
                    row.find('.price-result').text(formattedRoundedPrice);

                    updateAmounts();
                    updateTotals();
                    newUpdateFormDetailTransaction();
                });

                // Event listener untuk tombol "Hapus" pada baris produk di tbody #selectedData
                $('#selectedData').on('click', '.remove-btn', function() {
                    var row = $(this).closest('tr');
                    var productId = row.find('.id-detail-product').text().trim();

                    // Hapus produk dari array newSelectedProductIds jika dihapus
                    var index = newSelectedProductIds.indexOf(parseInt(productId));
                    if (index !== -1) {
                        newSelectedProductIds.splice(index, 1);
                    }

                    row.remove();

                    updateAmounts();
                    updateTotals();
                    newUpdateFormDetailTransaction();
                });

                $('#memberModal').modal('hide');
            });
            // Event handler ketika tombol "Pilih" diklik END

            // FORM TRANSACTION VALUE
            // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
            function setTodayDate() {
                var today = new Date();
                var day = String(today.getDate()).padStart(2, '0'); // Mengambil tanggal, 2 digit
                var month = String(today.getMonth() + 1).padStart(2, '0'); // Mengambil bulan, 2 digit
                var year = today.getFullYear(); // Mengambil tahun 4 digit

                var formattedDate = year + '-' + month + '-' + day; // Format YYYY-MM-DD

                // Mengisi input dengan nilai tanggal hari ini
                document.getElementById('date').value = formattedDate;
            }

            // Panggil fungsi untuk mengatur tanggal saat ini pada input date
            setTodayDate();

            function validateDetailTransactionForm() {
                var isValid = true;

                // Cek apakah ada input selain yang memiliki id="id_transaction"
                var totalInputs = $('#formDetailTransaction input').length; // Total input dalam form
                var otherInputs = $('#formDetailTransaction input').not('#id_transaction')
                    .length; // Input selain id_transaction

                var totalInputsNew = $('#newFormDetailTransaction input').length; // Total input dalam form
                var otherInputsNew = $('#newFormDetailTransaction input').not('#id_transaction')
                    .length; // Input selain id_transaction

                if (otherInputs === 0 && otherInputsNew === 0) {
                    isValid = false; // Jika tidak ada input selain id_transaction, form tidak valid
                }

                return isValid; // Kembalikan status validasi
            }

            $('#submitButton').click(function(event) {
                event.preventDefault(); // Mencegah form dari pengiriman otomatis

                var formProformaInvoice = $('#formProformaInvoice');
                var formDetailTransaction = $('#formDetailTransaction');
                var newFormDetailTransaction = $('#newFormDetailTransaction'); // Form baru

                // Nonaktifkan tombol submit untuk mencegah pengiriman berulang
                $('#submitButton').prop('disabled', true);

                // Reset pesan kesalahan sebelumnya
                $('.error-message').hide();
                $('.form-control').removeClass('is-invalid');
                $('.input-group').removeClass('has-error');

                var selectedClientId = $('#selectedClientId').val();
                if (!selectedClientId) {
                    $('#selectedClientId_error').text('Client harus dipilih').show();
                    $('#selectedClientName').addClass('is-invalid'); // Tambah border merah pada input
                    $('.input-group').addClass('has-error'); // Tambah border merah pada grup input
                }

                var selectedConsigneeId = $('#selectedConsigneeId').val();
                if (!selectedConsigneeId) {
                    $('#selectedConsigneeId_error').text('Consignee harus dipilih').show();
                    $('#selectedConsigneeName').addClass('is-invalid'); // Tambah border merah pada input
                    $('.input-group').addClass('has-error'); // Tambah border merah pada grup input
                }

                var net_weight_transaction = $('#net_weight_transaction').val();
                if (!net_weight_transaction) {
                    $('.net_weight_transaction').addClass('is-invalid'); // Tambah border merah pada input
                }

                // Validasi product (id_product harus dipilih)
                var product = $('#product').val();
                if (!product) {
                    $('#product_error').text('Produk harus dipilih').show();
                    $('#product').addClass('is-invalid'); // Tambahkan border merah
                }

                // Validasi commodity (id_commodity harus dipilih)
                var commodity = $('#commodity').val();
                if (!commodity) {
                    $('#commodity_error').text('Komoditas harus dipilih').show();
                    $('#commodity').addClass('is-invalid'); // Tambahkan border merah
                }

                // Panggil fungsi untuk memperbarui form detail transaksi baru dari data di tabel
                newUpdateFormDetailTransaction(); // <-- Panggil di sini sebelum submit form
                updateFormDetailTransaction(); // <-- Panggil di sini sebelum submit form

                function hasInputData(form) {
                    // Cari input hidden di dalam form, filter hanya yang punya value (bukan input kosong)
                    return form.find(':input').filter(function() {
                        return $.trim($(this).val()).length > 0;
                    }).length > 0;
                }

                var hasInvoiceData = hasInputData(formProformaInvoice);
                var hasDetailTransactionData = hasInputData(formDetailTransaction);
                var hasNewDetailTransactionData = hasInputData(newFormDetailTransaction);

                // Validasi formDetailTransaction terlebih dahulu
                var isValidDetailTransaction = validateDetailTransactionForm();

                if (!isValidDetailTransaction) {
                    $('#submitButton').prop('disabled', false);
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: 'Mohon isi data detail transaksi!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan proses jika form detail transaksi tidak valid
                }

                $.ajax({
                    url: formProformaInvoice.attr('action'),
                    method: formProformaInvoice.attr('method'),
                    data: formProformaInvoice.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Proforma Invoice berhasil diperbarui.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Submit formDetailTransaction jika ada input di dalamnya
                            if (hasDetailTransactionData) {
                                $.ajax({
                                    url: formDetailTransaction.attr(
                                        'action'),
                                    method: formDetailTransaction.attr(
                                        'method'),
                                    data: formDetailTransaction.serialize(),
                                    success: function(response) {
                                        detailTransactionSuccess = true;
                                        // Setelah detail transaksi berhasil disimpan
                                        if (hasNewDetailTransactionData) {
                                            $.ajax({
                                                url: newFormDetailTransaction
                                                    .attr('action'),
                                                method: newFormDetailTransaction
                                                    .attr('method'),
                                                data: newFormDetailTransaction
                                                    .serialize(),
                                                success: function(
                                                    response) {
                                                    newDetailTransactionSuccess
                                                        = true;
                                                    // Setelah detail transaksi baru berhasil disimpan, reload halaman
                                                    location
                                                        .reload();
                                                },
                                                error: function(
                                                    xhr) {
                                                    $('#submitButton')
                                                        .prop(
                                                            'disabled',
                                                            false
                                                        );
                                                    console
                                                        .error(
                                                            'Detail transaksi baru gagal ditambahkan! ' +
                                                            xhr
                                                            .responseJSON
                                                            .message
                                                        );
                                                }
                                            });
                                        } else {
                                            // Jika tidak ada detail transaksi baru, reload halaman
                                            location.reload();
                                        }
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Detail transaksi gagal diperbarui: ' +
                                                xhr.responseJSON
                                                .message,
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            $('#submitButton')
                                                .prop(
                                                    'disabled',
                                                    false);
                                        });
                                    }
                                });
                            } else if (hasNewDetailTransactionData) {
                                // Jika tidak ada detail transaksi tetapi ada transaksi baru
                                $.ajax({
                                    url: newFormDetailTransaction.attr(
                                        'action'),
                                    method: newFormDetailTransaction.attr(
                                        'method'),
                                    data: newFormDetailTransaction
                                        .serialize(),
                                    success: function(response) {
                                        newDetailTransactionSuccess =
                                            true;
                                        location
                                            .reload(); // Reload halaman setelah semua berhasil
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Detail transaksi baru gagal ditambahkan!: ' +
                                                xhr.responseJSON
                                                .message,
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            $('#submitButton')
                                                .prop(
                                                    'disabled',
                                                    false);
                                        });
                                    }
                                });
                            } else {
                                // Jika tidak ada detail transaksi dan tidak ada transaksi baru
                                location
                                    .reload(); // Reload halaman setelah semua berhasil
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Tangani error validasi dari server
                            var errors = xhr.responseJSON.errors;

                            // Loop melalui setiap error dan tampilkan di elemen input terkait
                            $.each(errors, function(key, value) {
                                var errorElement = $('#' + key + '_error');
                                var inputElement = $('#' + key);

                                // Tampilkan pesan error
                                errorElement.text(value[0]).show();
                                inputElement.addClass(
                                    'is-invalid'
                                ); // Tambah kelas is-invalid untuk border merah
                            });
                        } else {
                            // Tangani error umum
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                text: 'Gagal menyimpan transaksi: ' + xhr
                                    .responseJSON
                                    .message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        $('#submitButton').prop('disabled',
                            false); // Aktifkan tombol kembali
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Event listener untuk select client
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                var clientName = $('#client_id option:selected').text();

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedConsigneeId').val(''); // Kosongkan nilai ID consignee
                $('#selectedConsigneeName').val('');

                // Memuat data consignee berdasarkan ID client yang dipilih
                loadConsignees(clientId);
            });

            var consigneeTable = $('#consigneeModalTable').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('consignees.byClient', '0') }}",
                    data: function(d) {
                        d.clientId = $('#selectedClientId').val();
                    },
                    dataSrc: function(json) {
                        if (json.data.length === 0) {
                            if ($('#selectedClientId').val() === '') {
                                consigneeTable.settings()[0].oLanguage.sEmptyTable =
                                    "Harap pilih client terlebih dahulu";
                            } else {
                                consigneeTable.settings()[0].oLanguage.sEmptyTable =
                                    "Tidak ada consignee untuk client ini";
                            }
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'tel',
                        name: 'tel',
                        class: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center">
                                <button class="btn btn-primary select-consignee" data-id="${row.id}" data-name="${row.name}">Pilih</button>
                            </div>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    search: "Cari :",
                    infoFiltered: "(disaring dari total _MAX_ entri)",
                    emptyTable: "Harap pilih client terlebih dahulu"
                },
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                drawCallback: function() {
                    $('#consigneeModalTable td:nth-child(2), #consigneeModalTable th:nth-child(2)')
                        .css({
                            'max-width': '200px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                    $('#consigneeModalTable td:nth-child(3), #consigneeModalTable th:nth-child(3)')
                        .css({
                            'max-width': '250px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                }
            });

            // Fungsi untuk memuat data consignee berdasarkan ID client
            window.loadConsignees = function(clientId) {
                consigneeTable.ajax.url("{{ route('consignees.byClient', '') }}/" + clientId).load();
            };

            // Event listener untuk tombol buka modal consignee
            $('#openConsigneeModal').on('click', function() {
                var clientId = $('#selectedClientId').val();

                if (!clientId) {
                    consigneeTable.ajax.url("{{ route('consignees.byClient', '0') }}").load();
                }

                $('#consigneeModal').modal('show');
            });

            // Event listener untuk tombol "Pilih" di tabel consignee
            $('#consigneeModalTable tbody').on('click', '.select-consignee', function() {
                var consigneeId = $(this).data('id');
                var consigneeName = $(this).data('name');

                $('#selectedConsigneeId').val(consigneeId);
                $('#selectedConsigneeName').val(consigneeName);
                $('#consigneeModal').modal('hide');
            });

            // Muat consignee saat halaman dimuat
            var initialClientId = $('#selectedClientId').val();
            if (initialClientId) {
                loadConsignees(initialClientId);
            }
        });

        $(document).ready(function() {
            // Event listener untuk select client
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                var clientName = $('#client_id option:selected').text();

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyId').val(''); // Kosongkan nilai ID client company
                $('#selectedClientCompanyName').val('');

                // Memuat data client company berdasarkan ID client yang dipilih
                loadClientCompanies(clientId);
            });

            const clientCompanyTable = $('#clientCompanyModalTable').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('clientCompanies.byClient', ['clientId' => 0]) }}", // Default clientId kosong
                    data: function(d) {
                        d.clientId = $('#selectedClientId').val();
                    },
                    dataSrc: function(json) {
                        if (json.data.length === 0) {
                            if ($('#selectedClientId').val() === '') {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Harap pilih client terlebih dahulu";
                            } else {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Tidak ada perusahaan untuk client ini";
                            }
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'PO_BOX',
                        name: 'PO_BOX',
                        class: 'text-center'
                    },
                    {
                        data: 'tel',
                        name: 'tel',
                        class: 'text-center'
                    },
                    {
                        data: 'fax',
                        name: 'fax',
                        class: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <div class="text-center">
                            <button class="btn btn-primary select-client-company" data-id="${row.id}" data-name="${row.company_name}">Pilih</button>
                        </div>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    search: "Cari :",
                    infoFiltered: "(disaring dari total _MAX_ entri)",
                    emptyTable: "Harap pilih client terlebih dahulu"
                },
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                drawCallback: function() {
                    $('#clientCompanyModalTable td:nth-child(2), #clientCompanyModalTable th:nth-child(2)')
                        .css({
                            'max-width': '200px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                    $('#clientCompanyModalTable td:nth-child(3), #clientCompanyModalTable th:nth-child(3)')
                        .css({
                            'max-width': '250px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                }
            });

            // Memuat data client companies berdasarkan client ID
            window.loadClientCompanies = function(clientId) {
                const url = "{{ route('clientCompanies.byClient', ['clientId' => ':clientId']) }}".replace(
                    ':clientId', clientId || 0);
                clientCompanyTable.ajax.url(url).load();
            };

            // Event listener untuk membuka modal client company
            $('#openClientCompanyModal').on('click', function() {
                const clientId = $('#selectedClientId').val();
                loadClientCompanies(clientId || 0);
                $('#clientCompanyModal').modal('show');
            });

            // Event listener untuk memilih client company dari modal
            $('#clientCompanyModalTable tbody').on('click', '.select-client-company', function() {
                const clientCompanyId = $(this).data('id');
                const clientCompanyName = $(this).data('name');

                $('#selectedClientCompanyId').val(clientCompanyId);
                $('#selectedClientCompanyName').val(clientCompanyName);
                $('#clientCompanyModal').modal('hide');
            });

            // Muat client company saat halaman dimuat
            const initialClientId = $('#selectedClientId').val();
            if (initialClientId) {
                loadClientCompanies(initialClientId);
            }
        });
    </script>
@endsection
