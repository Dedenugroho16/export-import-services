@extends('layouts.layout')
@section('title', 'Proforma Invoice')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Proforma Invoice</h3>
                        </div>
                        <div class="card-body">
                            <p id="country_error" style="color: red; display: none;">Harap menginput negara terlebih
                                dahulu</p>
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

                            <form id="formProformaInvoice" method="POST" action="{{ route('proforma.store') }}">
                                @csrf
                                <input type="date" name="date" id="date" hidden>
                                <input type="text" name="code" id="code" hidden>
                                <input type="text" name="number" id="number" hidden>
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
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <p><strong>Set Country</strong></p>
                                                            </div>
                                                            <div class="col-3 text-center">
                                                                <span>:</span>
                                                            </div>
                                                            <div class="col-5">
                                                                <select class="form-control country" id="country"
                                                                    name="id_country" required></select>
                                                            </div>
                                                        </div>
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
                                                                        <input type="text" class="form-control"
                                                                            id="selectedClientName"
                                                                            placeholder="Pilih Client" readonly>
                                                                        <input type="hidden" id="selectedClientId"
                                                                            name="id_client">
                                                                        <div class="btn-group">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-md"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#clientsModal">
                                                                                <i data-feather="search"></i> Cari
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <span class="error-message" id="selectedClientId_error"
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
                                                                            placeholder="Pilih Consignee" readonly>
                                                                        <input type="hidden" id="selectedConsigneeId"
                                                                            name="id_consignee">
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
                                                                    placeholder="Enter notify party" required>
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
                                                                placeholder="Enter port of loading" required>
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
                                                                placeholder="Enter place of receipt" required>
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
                                                                placeholder="Enter port of discharge" required>
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
                                                                placeholder="Enter place of delivery" required>
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
                                                                <select class="form-control product" id="product"
                                                                    name="id_product" required>
                                                                    <option value="">Pilih Product</option>
                                                                    <!-- Placeholder option -->
                                                                </select>
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
                                                                        <option value="{{ $commodity->id }}">
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
                                                                    required>
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
                                                                    placeholder="Masukkan Payment term" required>
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
                                                                    step="0.01" max="9999999.99" readonly>
                                                                <span class="error-message" id="net_weight_error"
                                                                    style="color: red; display: none;"></span>
                                                                <input type="hidden" id="net_weight_transaction"
                                                                    name="net_weight" class="form-control" step="0.01"
                                                                    max="9999999.99" placeholder="Contoh: 123.45"
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
                                                                    placeholder="Masukkan gross weight" required>
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
                                                                    placeholder="Masukkan Product NCM" required>
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
                                                                    placeholder="Masukkan Payment Condition" required>
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
                                                    <th class="text-center">Item Description</th>
                                                    <th class="text-center">Carton(pcs)</th>
                                                    <th class="text-center">Inner(pcs)</th>
                                                    <th class="text-center">Unit Price(USD/KG)</th>
                                                    <th class="text-center">Net Weight(KG)</th>
                                                    <th class="text-center">Price Amount(USD)</th>
                                                    <th class="text-center">Aksi</th>
                                                </thead>
                                                <tbody id="detail-rows" style="font-size: 12px">
                                                    <tr id="nullDetailTransaction">
                                                        <td colspan="8" class="text-center">Tidak ada barang</td>
                                                    </tr>
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
                                                        <td class="text-end" colspan="5">
                                                            <label for="total" class="mr-2">Total:</label>
                                                        </td>
                                                        <td class="text-center" id="amount-total-price">
                                                            <div
                                                                class="form-group d-flex align-items-center justify-content-center">
                                                                <input type="text" step="0.01"
                                                                    class="form-control total-display" readonly>
                                                                <input type="hidden" step="0.01" class="form-control"
                                                                    id="total" name="total">
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
                                action="{{ route('detailtransaction.store') }}">
                                @csrf
                                <!-- Hidden inputs will be generated here -->
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <a href="{{ route('proforma.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal Client --}}
    <div class="modal fade text-left" id="clientsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Pilih Client</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table card-table table-vcenter text-nowrap" id="clientsModalTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
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

    {{-- modal Consignee --}}
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
                                <th class="text-center">No</th>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#product').select2({
                placeholder: "Pilih Product",
                ajax: {
                    url: '/ajax-products', // URL endpoint for fetching products
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Search term
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
                    // Display name and code in the selected option
                    return $('<span>' + product.text + ' (' + product.abbreviation + ')</span>');
                }
            });

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

            // Initialize Select2 for countries
            $('#country').select2({
                ajax: {
                    url: '/ajax-countries',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(country) {
                                return {
                                    id: country.id,
                                    text: country.text + ' (' + country.code + ')',
                                    code: country.code // Tambahkan kode negara langsung di data
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: "Select a country",
                templateResult: function(country) {
                    if (country.loading) return country.text;
                    return $('<span>' + country.text + '</span>');
                },
                templateSelection: function(country) {
                    return $('<span>' + country.text + '</span>');
                }
            });

            // Set default Indonesia dan tambahkan data-code di data yang dipilih
            $.ajax({
                url: '/ajax-countries',
                dataType: 'json',
                success: function(data) {
                    const indonesia = data.find(country => country.code === "ID");
                    if (indonesia) {
                        const option = new Option(indonesia.text + ' (' + indonesia.code + ')',
                            indonesia.id, true, true);
                        $(option).attr('data-code', indonesia
                            .code); // Set data-code khusus untuk Indonesia
                        $('#country').append(option).trigger('change');
                    }
                }
            });
        });

        $(document).ready(function() {
            const grossWeightDisplay = document.getElementById('gross_weight_display');
            const grossWeight = document.getElementById('gross_weight');

            // Event listener untuk memformat input saat user mengetik (Gross Weight)
            grossWeightDisplay.addEventListener('input', function(e) {
                // Ambil nilai yang diinputkan, lalu bersihkan format non-angka kecuali titik dan angka
                let value = e.target.value.replace(/[^.\d]/g, '');
                // Update nilai input tersembunyi dengan angka asli tanpa format
                grossWeight.value = value.replace(/,/g, '');
                // Format input tampilan dengan pemisah ribuan (koma) dan titik sebagai desimal
                e.target.value = formatDollar(value);
            });
            // Bagian untuk freight cost
            const freightCostDisplay = document.getElementById('freight_cost_display');
            const freightCost = document.getElementById('freight_cost');

            freightCostDisplay.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^.\d]/g, '');
                freightCost.value = value.replace(/,/g, '');
                e.target.value = formatDollar(value);
            });

            // Fungsi untuk memformat angka dalam format dolar
            function formatDollar(angka) {
                // Pisahkan angka menjadi bagian sebelum dan setelah titik desimal
                let parts = angka.split('.');

                // Format bagian sebelum desimal (ribuan) dengan koma
                let sisa = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Gabungkan kembali jika ada bagian desimal
                return parts[1] !== undefined ? sisa + '.' + parts[1] : sisa;
            }
        });


        // modal datatables
        $(document).ready(function() {
            // Update button and error message visibility based on the default value
            if ($('#country').val() === "") {
                $('#submitButton').prop('disabled', true);
                $('#country_error').show();
            } else {
                $('#submitButton').prop('disabled', false);
                $('#country_error').hide();
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

            var table = $('#detailProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-detail-products') }}",
                    data: function(d) {
                        var productId = $('#product').val();
                        d.id_product = productId ? productId :
                            null; // Kirim nilai id_product jika produk dipilih
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
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
                        sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
                    },
                    select: {
                        rows: {
                            _: "%d baris terpilih",
                            1: "1 baris terpilih"
                        }
                    }
                },
                responsive: true,
                autoWidth: false,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10
            });

            // Event ketika user memilih produk
            $('#product').change(function() {
                function updateAmounts() {
                    var totalCarton = 0;
                    var totalInner = 0;
                    var totalNetWeight = 0;
                    var PriceAmount = 0;

                    // Jika tabel kosong atau hanya ada baris "Tidak ada barang", reset semua nilai ke 0
                    if ($('#tableDetailTransaction tbody tr').length === 0 || $(
                            '#tableDetailTransaction tbody').find('#nullDetailTransaction').length > 0) {
                        totalCarton = 0;
                        totalInner = 0;
                        totalNetWeight = 0;
                        PriceAmount = 0;
                    } else {
                        // Iterasi setiap baris untuk mendapatkan nilai total
                        $('#tableDetailTransaction tbody tr').each(function() {
                            var carton = parseFloat($(this).find('.carton-input').val().replace(
                                /,/g, '')) || 0;
                            var inner = parseFloat($(this).find('.inner-result').text().replace(
                                /,/g, '')) || 0;
                            var netWeight = parseFloat($(this).find('.net-weight').text().replace(
                                /,/g, '')) || 0;
                            var price = parseFloat($(this).find('.price-result').text().replace(
                                /,/g, '')) || 0;

                            totalCarton += carton;
                            totalInner += inner;
                            totalNetWeight += netWeight;
                            PriceAmount += price;
                        });
                    }

                    // Format hasil perhitungan dengan pemisah ribuan en-US
                    var formattedTotalCarton = totalCarton.toLocaleString('en-US');
                    var formattedTotalInner = totalInner.toLocaleString('en-US');
                    var formattedTotalNetWeight = totalNetWeight.toLocaleString('en-US');
                    var formattedPriceAmount = PriceAmount.toLocaleString('en-US');

                    // Update nilai total di footer dengan format yang benar
                    $('#totalCarton').text(formattedTotalCarton);
                    $('#totalInner').text(formattedTotalInner);
                    $('#totalNetWeight').text(formattedTotalNetWeight);
                    $('#PriceAmount').text(formattedPriceAmount);

                    // Set value total net weight untuk field form
                    $('#net_weight_transaction').val(totalNetWeight);
                    $('.net_weight_transaction').val(formattedTotalNetWeight);
                }

                // Fungsi untuk memperbarui total price amount
                function updateTotals() {
                    var priceAmount = parseFloat($('#PriceAmount').text().replace(/,/g, '')) || 0;

                    var freightCost = parseFloat($('#freight_cost_display').val().replace(/,/g, '')) || 0;

                    var total = priceAmount + freightCost;

                    var formattedGrandTotal = total.toLocaleString('en-US');
                    $('.total-display').val(formattedGrandTotal);

                    $('#total').val(total);
                }

                if ($(this).val()) {
                    table.ajax.reload(); // Reload DataTables dengan data produk yang dipilih
                } else {
                    table.clear().draw(); // Kosongkan tabel jika tidak ada produk yang dipilih
                }

                // Ketika product diubah, hapus semua baris yang telah ditambahkan dari tabel #tableDetailTransaction
                $('#tableDetailTransaction tbody tr').remove();
                $('#formDetailTransaction').empty();

                if ($('#tableDetailTransaction tbody tr').length === 0) {
                    $('#tableDetailTransaction tbody').append(`
            <tr id="nullDetailTransaction">
                <td colspan="7" class="text-center">Tidak ada barang</td>
            </tr>`);
                }

                // Kosongkan array selectedProductIds
                selectedProductIds = [];
                updateAmounts();
                updateTotals();
            });

            // event untuk code transaksi
            // Fungsi untuk mendapatkan dua digit bulan dan dua digit tahun dari tanggal saat ini
            function getTwoDigitYearMonth() {
                var date = new Date();
                var year = date.getFullYear().toString().slice(-2); // Mengambil dua digit terakhir dari tahun
                var month = ("0" + (date.getMonth() + 1)).slice(-2); // Mengambil dua digit bulan
                return year + month; // Menggabungkan dua digit tahun dan dua digit bulan
            }

            // Fungsi untuk memperbarui kode negara atau dua digit bulan
            function updateProductCode() {
                let countryCode;

                // Cek jika negara yang dipilih adalah Indonesia
                const selectedOption = $('#country option:selected');
                if (selectedOption && selectedOption.data('code') === "ID") {
                    const selectedOption = $('#country option:selected');
                    countryCode = selectedOption.data('code'); // Ambil data-code untuk Indonesia
                } else {
                    const countryData = $('#country').select2('data')[0];
                    countryCode = countryData ? countryData.code : null; // Ambil kode negara dari data Select2
                }

                // Get the selected product code from Select2
                var productData = $('#product').select2('data')[0]; // Get the selected data
                var productCode = productData ? productData.code : null; // Access the product code

                // Get two-digit year and month
                var twoDigitYearMonth = getTwoDigitYearMonth(); // Function to get the year + month

                // If both product and country codes exist
                if (productCode && countryCode) {
                    var codeText = productCode + ' ' + countryCode + twoDigitYearMonth;
                    $('#product-code').text(codeText);
                    $('#code').val(codeText); // Set input value
                }
                // If a product is selected but no country is selected
                else if (productCode) {
                    $('#product-code').text(productCode + ' ' + 'pilih negara!' + twoDigitYearMonth);
                }
                // If a country is selected but no product is selected
                else if (countryCode) {
                    $('#product-code').text(countryCode + twoDigitYearMonth);
                }
                // If neither product nor country is selected
                else {
                    $('#product-code').text('-');
                }
            }

            function updateNumber() {
                // Ambil data kode negara tergantung apakah negara yang dipilih adalah Indonesia atau bukan
                let countryCode;

                // Cek jika negara yang dipilih adalah Indonesia
                const selectedOption = $('#country option:selected');
                if (selectedOption && selectedOption.data('code') === "ID") {
                    const selectedOption = $('#country option:selected');
                    countryCode = selectedOption.data('code'); // Ambil data-code untuk Indonesia
                } else {
                    const countryData = $('#country').select2('data')[0];
                    countryCode = countryData ? countryData.code : null; // Ambil kode negara dari data Select2
                }

                // Ambil singkatan produk dari Select2
                const productData = $('#product').select2('data')[0];
                const productAbbreviation = productData ? productData.abbreviation : null;

                // Dapatkan tanggal saat ini
                const currentDate = new Date();

                // Dapatkan bulan dalam format dua digit (contoh: 09 untuk September)
                const twoDigitMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);

                // Dapatkan bulan dalam format angka Romawi
                const romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                const romanMonth = romanMonths[currentDate.getMonth()];

                // Dapatkan tahun dalam format dua digit
                const twoDigitYear = currentDate.getFullYear().toString().slice(-2);

                // Cek apakah productAbbreviation dan countryCode ada
                if (productAbbreviation && countryCode) {
                    const formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    const finalNumber = '{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber;
                    $('#numberDisplay').text(finalNumber);
                    $('#number').val(finalNumber); // Setel nilai input
                } else if (productAbbreviation) {
                    const formattedNumber = '/' + twoDigitMonth + '/INV/' + romanMonth + '/' + twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber);
                } else if (countryCode) {
                    const formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + ' ' + formattedNumber);
                } else {
                    $('#numberDisplay').text('{{ $formattedNumber }}');
                }
            }

            // Pantau perubahan pada dropdown product dan country untuk memperbarui kode
            $('#product, #country').on('change', function() {
                updateProductCode();
                updateNumber();
            });

            // Jalankan fungsi updateProductCode saat halaman dimuat untuk menginisialisasi
            updateProductCode();
            updateNumber();

            // Tabel Detail Transaction
            // Event handler ketika tombol "Pilih" diklik
            var selectedProductIds = [];
            $('#detailProductTable tbody').on('click', '.pilih-btn', function() {
                var data = table.row($(this).parents('tr'))
                    .data();

                if (selectedProductIds.includes(data.id)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Produk sudah dipilih',
                        text: 'Detail product ini sudah dipilih. Silakan pilih produk lain.',
                        confirmButtonText: 'OK'
                    });
                    $('#memberModal').modal('hide');
                    return;
                }

                // Membuat elemen tr untuk ditambahkan ke tabel #tableDetailTransaction
                var newRow = `
        <tr>
            <td class="text-center id-detail-product" style="display: none;">${data.id}</td>
            <td class="text-center">
                <strong>${data.name} ${data.pcs} PCS / <input type="number" class="form-control qty-input" style="width: 70px; display: inline-block;" placeholder="Qty" min="1" max="999" /> KG</strong><br>
                ${data.dimension} ${data.color} - ${data.type}
            </td>
            <td class="text-center">
                <input type="text" class="form-control carton-input" style="width: 100px; display: inline-block;" placeholder="Carton" min="1" max="9999" />
                <input type="hidden" class="carton_input" name="carton_input">
            </td>
            <td class="text-center inner-result">
                0
            </td>
            <td class="text-center price">${data.price}</td>
            <td class="text-center net-weight">0</td>
            <td class="text-center price-result">0</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm remove-btn">Hapus</button>
            </td>
        </tr>`;

                selectedProductIds.push(data.id);

                // Menambahkan elemen tr baru ke tabel #tableDetailTransaction
                $('#tableDetailTransaction tbody').append(newRow);

                // Menghapus baris "Tidak ada barang" jika ada
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


                // Event listener to calculate the result
                $('#tableDetailTransaction tbody').on('input', '.qty-input, .carton-input', function() {
                    var row = $(this).closest('tr');
                    var qtyInput = row.find('.qty-input');
                    var cartonInput = row.find('.carton-input');

                    var qty = parseFloat(qtyInput.val()) || 0;
                    var carton = parseFloat(cartonInput.val().replace(/,/g,
                        '')) || 0;
                    var price = parseFloat(row.find('.price').data('price')) || 0;

                    // Batas maksimum untuk qty dan carton
                    var maxQty = 999; // Maksimum 3 digit
                    var maxCarton = 999999; // Maksimum 6 digit

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
                    var totalPrice = result * data.price;
                    // Round the total price to the nearest integer
                    var roundedPrice = Math.round(totalPrice);
                    var formattedPrice = roundedPrice.toLocaleString('en-US');
                    row.find('.price-result').text(formattedPrice);

                    // Update total values in the footer
                    updateAmounts();
                    updateTotals();
                    updateFormDetailTransaction();
                });

                function updateFormDetailTransaction() {
                    // Clear previous inputs
                    $('#formDetailTransaction').empty();

                    $('#formDetailTransaction').append(`
                        <input type="hidden" name="id_transaction" id="id_transaction">
                    `);

                    // Iterate through each row of the table
                    $('#tableDetailTransaction tbody tr').each(function(index, row) {
                        // Skip the row if it is the 'No data' row
                        if ($(row).attr('id') === 'nullDetailTransaction') return;

                        var idDetailProduct = $(row).find('.id-detail-product').text().trim();
                        var qty = parseFloat($(row).find('.qty-input').val().replace(/,/g, '')) ||
                            0; // Hapus koma dari qty
                        var carton = parseFloat($(row).find('.carton-input').val().replace(/,/g,
                            '')) || 0; // Hapus koma dari carton
                        var inner = parseFloat($(row).find('.inner-result').text().trim().replace(
                            /,/g, '')) || 0; // Hapus koma dari inner
                        var unitPrice = parseFloat($(row).find('.price').text().trim().replace(/,/g,
                            '')) || 0; // Hapus koma dari unit price
                        var netWeight = parseFloat($(row).find('.net-weight').text().trim().replace(
                            /,/g, '')) || 0;
                        var priceAmount = parseFloat($(row).find('.price-result').text().trim()
                            .replace(/,/g, '')) || 0; // Hapus koma dari price amount

                        // Create hidden inputs and append to the form
                        $('#formDetailTransaction').append(`
        <input type="hidden" name="transactions[${index}][id_detail_product]" id="id_detail_product" value="${idDetailProduct}">
        <input type="hidden" name="transactions[${index}][qty]" id="qty" value="${qty}">
        <input type="hidden" name="transactions[${index}][carton]" id="carton" value="${carton}">
        <input type="hidden" name="transactions[${index}][inner_qty_carton]" id="inner_qty_carton" value="${inner}">
        <input type="hidden" name="transactions[${index}][unit_price]" id="unit_price" value="${unitPrice}">
        <input type="hidden" name="transactions[${index}][net_weight]" id="net_weight" value="${netWeight}">
        <input type="hidden" name="transactions[${index}][price_amount]" id="price_amount" value="${priceAmount}">
    `);
                    });
                }

                function updateAmounts() {
                    var totalCarton = 0;
                    var totalInner = 0;
                    var totalNetWeight = 0;
                    var PriceAmount = 0;

                    // Jika tabel kosong atau hanya ada baris "Tidak ada barang", reset semua nilai ke 0
                    if ($('#tableDetailTransaction tbody tr').length === 0 || $(
                            '#tableDetailTransaction tbody').find('#nullDetailTransaction').length > 0) {
                        totalCarton = 0;
                        totalInner = 0;
                        totalNetWeight = 0;
                        PriceAmount = 0;
                    } else {
                        // Iterasi setiap baris untuk mendapatkan nilai total
                        $('#tableDetailTransaction tbody tr').each(function() {
                            var carton = parseFloat($(this).find('.carton-input').val().replace(
                                /,/g, '')) || 0;
                            var inner = parseFloat($(this).find('.inner-result').text().replace(
                                /,/g, '')) || 0;
                            var netWeight = parseFloat($(this).find('.net-weight').text().replace(
                                /,/g, '')) || 0;
                            var price = parseFloat($(this).find('.price-result').text().replace(
                                /,/g, '')) || 0;

                            totalCarton += carton;
                            totalInner += inner;
                            totalNetWeight += netWeight;
                            PriceAmount += price;
                        });
                    }

                    // Format hasil perhitungan dengan pemisah ribuan en-US
                    var formattedTotalCarton = totalCarton.toLocaleString('en-US');
                    var formattedTotalInner = totalInner.toLocaleString('en-US');
                    var formattedTotalNetWeight = totalNetWeight.toLocaleString('en-US');
                    var formattedPriceAmount = PriceAmount.toLocaleString('en-US');

                    // Update nilai total di footer dengan format yang benar
                    $('#totalCarton').text(formattedTotalCarton);
                    $('#totalInner').text(formattedTotalInner);
                    $('#totalNetWeight').text(formattedTotalNetWeight);
                    $('#PriceAmount').text(formattedPriceAmount);

                    // Set value total net weight untuk field form
                    $('#net_weight_transaction').val(totalNetWeight);
                    $('.net_weight_transaction').val(formattedTotalNetWeight);
                }

                // Fungsi untuk memperbarui total price amount
                function updateTotals() {
                    var priceAmount = parseFloat($('#PriceAmount').text().replace(/,/g, '')) || 0;

                    var freightCost = parseFloat($('#freight_cost_display').val().replace(/,/g, '')) || 0;

                    var total = priceAmount + freightCost;

                    var formattedGrandTotal = total.toLocaleString('en-US');
                    $('.total-display').val(formattedGrandTotal);

                    $('#total').val(total);
                }

                // Event listener untuk input Freight Cost
                $('#freight_cost_display').on('input', function() {
                    updateTotals();
                });

                // Event handler untuk tombol "Hapus" pada #tableDetailTransaction
                $('#tableDetailTransaction tbody').on('click', '.remove-btn', function() {
                    var row = $(this).closest('tr');
                    var productId = row.find('.id-detail-product').text().trim();

                    // Hapus produk dari array newSelectedProductIds jika dihapus
                    var index = selectedProductIds.indexOf(parseInt(productId));
                    if (index !== -1) {
                        selectedProductIds.splice(index, 1);
                    }

                    row.remove();

                    // Jika tidak ada baris lagi, tambahkan kembali baris "Tidak ada barang"
                    if ($('#tableDetailTransaction tbody tr').length === 0) {
                        $('#tableDetailTransaction tbody').append(`
            <tr id="nullDetailTransaction">
                <td colspan="7" class="text-center">Tidak ada barang</td>
            </tr>`);
                    }

                    updateAmounts();
                    updateTotals();
                    updateFormDetailTransaction();
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

                if (otherInputs === 0) {
                    isValid = false; // Jika tidak ada input selain id_transaction, form tidak valid
                }

                return isValid; // Kembalikan status validasi
            }

            $('#submitButton').click(function() {
                var formProformaInvoice = $('#formProformaInvoice');
                var formDetailTransaction = $('#formDetailTransaction');

                // Nonaktifkan tombol submit
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

                // Submit formProformaInvoice terlebih dahulu
                $.ajax({
                    url: formProformaInvoice.attr('action'),
                    method: formProformaInvoice.attr('method'),
                    data: formProformaInvoice.serialize(),
                    success: function(response) {
                        // Pastikan response.id berisi ID transaksi yang valid
                        if (response.id) {
                            // Set ID transaksi ke input hidden pada form detail transaksi
                            $('#id_transaction').val(response.id); // Isi ID transaksi pada form

                            // Selanjutnya submit formDetailTransaction
                            $.ajax({
                                url: formDetailTransaction.attr('action'),
                                method: formDetailTransaction.attr('method'),
                                data: formDetailTransaction.serialize(),
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Proforma invoice berhasil ditambahkan.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                },
                                error: function(xhr) {
                                    // Tangani error untuk detail transaksi
                                    Swal.fire({
                                        title: 'Terjadi Kesalahan!',
                                        text: 'Gagal menyimpan detail transaksi: ' +
                                            xhr.responseJSON.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                complete: function() {
                                    // Aktifkan kembali tombol setelah selesai (sukses/gagal)
                                    $('#submitButton').prop('disabled', false);
                                }
                            });
                        } else {
                            alert('Transaction ID is missing');
                            // Aktifkan kembali tombol jika ID tidak valid
                            $('#submitButton').prop('disabled', false);
                        }
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
                                text: 'Gagal menyimpan transaksi: ' + xhr.responseJSON
                                    .message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        $('#submitButton').prop('disabled', false); // Aktifkan tombol kembali
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#clientsModalTable').DataTable({
                autoWidth: false,
                processing: false,
                serverSide: true,
                ajax: "{{ route('clients.index') }}",
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
                            return `<button class="btn btn-primary select-client" data-id="${row.id}" data-name="${row.name}">Pilih</button>`;
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
                    infoFiltered: "(disaring dari total _MAX_ entri)"
                },
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                drawCallback: function() {
                    $('#clientsModalTable td:nth-child(2), #clientsModalTable th:nth-child(2)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#clientsModalTable td:nth-child(3), #clientsModalTable th:nth-child(3)').css({
                        'max-width': '250px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });

            // Event listener untuk tombol "Pilih" di tabel client
            $('#clientsModalTable tbody').on('click', '.select-client', function() {
                var clientId = $(this).data('id');
                var clientName = $(this).data('name');

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedConsigneeId').val(''); // Kosongkan nilai ID consignee
                $('#selectedConsigneeName').val('');
                $('#clientsModal').modal('hide');

                // Hapus baris "Harap pilih client terlebih dahulu"
                $('#nullConsignee').hide();

                // Memuat data consignee berdasarkan ID client yang dipilih
                loadConsignees(clientId);
            });

            var consigneeTable = $('#consigneeModalTable').DataTable({
                autoWidth: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('consignees.byClient', '0') }}", // Set ID client ke '0' atau gunakan route lain yang menghasilkan data kosong
                    dataSrc: function(json) {
                        if (json.data.length === 0) {
                            if ($('#selectedClientId').val() === '' || $('#selectedClientId').val() ===
                                '0') {
                                // Jika client belum dipilih (clientId = 0 atau kosong), tampilkan pesan ini
                                consigneeTable.settings()[0].oLanguage.sEmptyTable =
                                    "Harap pilih client terlebih dahulu";
                            } else {
                                // Jika client sudah dipilih tetapi tidak ada consignee, tampilkan pesan ini
                                consigneeTable.settings()[0].oLanguage.sEmptyTable =
                                    "Tidak ada consignee untuk client ini";
                            }
                        }
                        return json.data;
                    }
                }, // diisi saat loadConsignees dipanggil
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
                    emptyTable: "Harap pilih client terlebih dahulu" // Ubah pesan saat tidak ada data
                },
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                drawCallback: function() {
                    // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
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
                if (!clientId) {
                    $('#nullConsignee').show();
                    consigneeTable.ajax.url("{{ route('consignees.byClient', '0') }}").load();
                    return;
                }

                consigneeTable.ajax.url("{{ route('consignees.byClient', '') }}/" + clientId).load();
            };

            // Event listener untuk tombol "Pilih" di tabel consignee
            $('#consigneeModalTable tbody').on('click', '.select-consignee', function() {
                var consigneeId = $(this).data('id');
                var consigneeName = $(this).data('name');

                $('#selectedConsigneeId').val(consigneeId);
                $('#selectedConsigneeName').val(consigneeName);
                $('#consigneeModal').modal('hide');
            });
        });
    </script>
@endsection
