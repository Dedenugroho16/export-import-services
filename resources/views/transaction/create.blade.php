@extends('layouts.layout')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Transaksi</h3>
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
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">INVOICE</h3>
                                        </div>
                                        <div class="card-body">
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
                                                <div class="col-6 d-flex justify-content-end align-items-start">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p><strong>Set Country</strong></p>
                                                        </div>
                                                        <div class="col-1 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="col-5">
                                                            <select class="form-control country" id="country">
                                                                <option value="">Pilih Negara</option>
                                                                @foreach ($country as $negara)
                                                                    <option value="{{ $negara->id }}"
                                                                        data-code="{{ $negara->code }}">
                                                                        {{ $negara->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formTransaction" method="POST" action="{{ route('transaction.store') }}">
                                @csrf
                                <input type="date" name="date" id="date" hidden>
                                <input type="text" name="code" id="code" hidden>
                                <input type="text" name="number" id="number" hidden>

                                <!-- Bagian 2: Consignee, Notify, Client -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Parties Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Client Input -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <select name="id_client" class="form-control client" id="client"
                                                        required>
                                                        <option value="">Pilih Client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}"
                                                                data-address="{{ $client->address }}">
                                                                {{ $client->name }}
                                                            </option>
                                                        @endforeach
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
                                                    <select name="id_consignee" class="form-control consignee"
                                                        id="consignee" required>
                                                        <option value="">Pilih Consignee</option>
                                                        @foreach ($consignees as $consignee)
                                                            <option value="{{ $consignee->id }}"
                                                                data-address="{{ $consignee->address }}">
                                                                {{ $consignee->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <!-- Element to display the address -->
                                                    <div id="consignee-address" style="margin-top: 10px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Bagian 3: Port of Loading, Place of Receipt, Port of Discharge, Place of Delivery -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Logistics Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
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
                                                        class="form-control" placeholder="Enter place of receipt"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Port of Discharge Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_discharge">Port of Discharge</label>
                                                    <input type="text" name="port_of_discharge" id="port_of_discharge"
                                                        class="form-control" placeholder="Enter port of discharge"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Place of Delivery Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_delivery">Place of Delivery</label>
                                                    <input type="text" name="place_of_delivery" id="place_of_delivery"
                                                        class="form-control" placeholder="Enter place of delivery"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- bagian 4 --}}
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">DETAILS</h3>
                                    </div>
                                    <div class="card-body">
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
                                                        <select class="form-control product" id="product"
                                                            name="id_product" required>
                                                            <option value="">Pilih Product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    data-code="{{ $product->code }}"
                                                                    data-abbreviation="{{ $product->abbreviation }}">
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
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
                                                        <select class="form-control commodity" id="commodity"
                                                            name="id_commodity" required>
                                                            <option value="">Pilih Commodity</option>
                                                            @foreach ($commodities as $commodity)
                                                                <option value="{{ $commodity->id }}">
                                                                    {{ $commodity->name }}
                                                                </option>
                                                            @endforeach
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
                                                            class="form-control" placeholder="Masukkan Container"
                                                            required>
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
                                                        <input type="hidden" id="net_weight_transaction"
                                                            name="net_weight" class="form-control" step="0.01"
                                                            placeholder="Contoh: 123.45" required>
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
                                                            class="form-control" step="0.01"
                                                            placeholder="Contoh: 123.45" required>
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
                                                            class="form-control" placeholder="Masukkan Payment term"
                                                            required>
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
                                                            class="form-control" placeholder="Masukkan BL Number"
                                                            required>
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
                                                        <input type="text" name="container_number"
                                                            id="container_number" class="form-control"
                                                            placeholder="Masukkan Container Number" required>
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
                                                            class="form-control" placeholder="Masukkan Seal Number"
                                                            required>
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
                                                            class="form-control" placeholder="Masukkan Product NCM"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- tabel detail transaction --}}
                                <div class="card mt-3">
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
                                        <div class="table-responsive pb-2 border-top" style="max-height: 18rem">
                                            <table class="table table-bordered table-hover table-striped table-sm"
                                                id="tableDetailTransaction">
                                                <thead>
                                                    <th class="text-center">ID</th>
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
                                                        <td></td>
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
                                                        <td></td>
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
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <input type="checkbox" name="approved" id="approved" value="1"> Approved
                            </form>

                            <form id="formDetailTransaction" method="POST"
                                action="{{ route('detailtransaction.store') }}">
                                @csrf
                                <!-- Hidden inputs will be generated here -->
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <a href="{{ url('/transaction') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
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
            // Menginisialisasi Select2
            $('#client').select2();
            $('#consignee').select2();
            $('#product').select2();
            $('#commodity').select2();
            $('#country').select2();

            // Ketika client dipilih
            $('#client').on('change', function() {
                var clientId = $(this).val(); // Ambil ID client yang dipilih

                // Ambil data dari Select2 untuk client yang dipilih
                var selectedClientData = $(this).select2('data')[0]; // Ambil objek data dari Select2

                // Tampilkan address di div jika ada
                if (selectedClientData && selectedClientData.element && $(selectedClientData.element).data(
                        'address')) {
                    var address = $(selectedClientData.element).data('address');
                    $('#client-address').html('<strong>Address: </strong>' + address);
                } else {
                    $('#client-address').html('');
                }

                // Jika clientId ada, lakukan AJAX untuk ambil consignees
                if (clientId) {
                    $.ajax({
                        url: '/get-consignees/' + clientId, // Panggil route yang sudah kita buat
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Hapus semua opsi lama dari select consignee
                            $('#consignee').empty();

                            // Tambahkan opsi baru berdasarkan consignees yang diterima
                            $('#consignee').append('<option value="">Pilih Consignee</option>');
                            $.each(data, function(key, consignee) {
                                $('#consignee').append('<option value="' + consignee
                                    .id + '" data-address="' + consignee.address +
                                    '">' + consignee.name + '</option>');
                            });

                            // Refresh Select2 setelah data diperbarui
                            $('#consignee').trigger('change');
                        }
                    });
                } else {
                    $('#consignee').empty();
                    $('#consignee-address').empty();
                    $('#consignee').append('<option value="">Pilih Consignee</option>');
                }
            });

            $('#consignee').on('change', function() {
                // Ambil data dari Select2 untuk client yang dipilih
                var selectedClientData = $(this).select2('data')[0]; // Ambil objek data dari Select2

                // Tampilkan address di div jika ada
                if (selectedClientData && selectedClientData.element && $(selectedClientData.element).data(
                        'address')) {
                    var address = $(selectedClientData.element).data('address');
                    $('#consignee-address').html('<strong>Address: </strong>' + address);
                } else {
                    $('#consignee-address').html('');
                }
            });
        });

        // modal datatables
        $(document).ready(function() {
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
                        data: 'id',
                        name: 'id',
                        title: "No"
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

            // Fungsi untuk memperbarui kode negara atau dua digit bulan
            function updateProductCode() {
                var countryCode = $('#country option:selected').data('code'); // Mengambil kode negara
                var productCode = $('#product option:selected').data('code'); // Mengambil kode produk
                var twoDigitYearMonth = getTwoDigitYearMonth(); // Mendapatkan dua digit tahun + dua digit bulan

                // Jika ada produk yang dipilih dan ada kode negara
                if (productCode && countryCode) {
                    var codeText = productCode + ' ' + countryCode + twoDigitYearMonth;
                    $('#product-code').text(codeText);
                    $('#code').val(codeText); // Mengisi input dengan nilai yang sama
                }
                // Jika produk dipilih, tapi negara belum dipilih
                else if (productCode) {
                    $('#product-code').text(productCode + ' ' + 'pilih negara!' + twoDigitYearMonth);
                }
                // Jika negara dipilih, tapi produk belum dipilih
                else if (countryCode) {
                    $('#product-code').text(countryCode + twoDigitYearMonth);
                }
                // Jika tidak ada produk atau negara yang dipilih
                else {
                    $('#product-code').text('-');
                }
            }

            function updateNumber() {
                var productAbbreviation = $('#product option:selected').data(
                    'abbreviation'); // Mengambil abbreviation produk
                var countryCode = $('#country option:selected').data('code'); // Mengambil kode negara

                // Mendapatkan tanggal saat ini
                var currentDate = new Date();

                // Mendapatkan dua digit bulan (misalnya 09 untuk September)
                var twoDigitMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);

                // Mendapatkan angka Romawi bulan
                var romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                var romanMonth = romanMonths[currentDate.getMonth()]; // Bulan dalam format Romawi

                // Mendapatkan dua digit tahun
                var twoDigitYear = currentDate.getFullYear().toString().slice(-2);

                if (productAbbreviation && countryCode) {
                    // Format yang diminta: 'countryCode/09/INV/II/24'
                    var formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    var finalNumber = '{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber;
                    $('#numberDisplay').text(finalNumber);
                    $('#number').val(finalNumber); // Mengisi input dengan nilai yang sama
                } else if (productAbbreviation) {
                    // Format yang diminta: 'countryCode/09/INV/II/24'
                    var formattedNumber = '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber);
                } else if (countryCode) {
                    // Format yang diminta: 'countryCode/09/INV/II/24'
                    var formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + ' ' +
                        formattedNumber);
                } else {
                    $('#numberDisplay').text('{{ $formattedNumber }}');
                }
            }

            // Pantau perubahan pada dropdown product dan country untuk memperbarui kode
            $('#product, #country').on('change', function() {
                updateProductCode();
                updateNumber()
            });

            // Jalankan fungsi updateProductCode saat halaman dimuat untuk menginisialisasi
            updateProductCode();
            updateNumber()

            // Tabel Detail Transaction
            // Event handler ketika tombol "Pilih" diklik
            $('#detailProductTable tbody').on('click', '.pilih-btn', function() {
                var data = table.row($(this).parents('tr'))
                    .data(); // Mengambil data dari baris yang dipilih

                // Membuat elemen tr untuk ditambahkan ke tabel #tableDetailTransaction
                var newRow = `
        <tr>
            <td class="text-center id-detail-product">${data.id}</td>
            <td class="text-center">
                <strong>${data.name} ${data.pcs} PCS / <input type="number" class="form-control qty-input" style="width: 70px; display: inline-block;" placeholder="Qty" min="1" /> KG</strong><br>
                ${data.dimension} ${data.color} - ${data.type}
            </td>
            <td class="text-center"><input type="number" class="form-control carton-input" style="width: 100px; display: inline-block;" placeholder="Carton" min="1" /></td>
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

                // Menambahkan elemen tr baru ke tabel #tableDetailTransaction
                $('#tableDetailTransaction tbody').append(newRow);

                // Menghapus baris "Tidak ada barang" jika ada
                $('#nullDetailTransaction').remove();

                // Event listener to calculate the result
                $('#tableDetailTransaction tbody').on('input', '.qty-input, .carton-input', function() {
                    var row = $(this).closest('tr');
                    var qty = parseFloat(row.find('.qty-input').val()) || 0;
                    var carton = parseFloat(row.find('.carton-input').val()) || 0;
                    var price = parseFloat(row.find('.price').data('price')) || 0;

                    // Multiply qty by carton and update the result
                    var result = qty * carton;
                    row.find('.inner-result').text(result);
                    row.find('.net-weight').text(result);
                    $('#net_weight_transaction').val(result);
                    $('.net_weight_transaction').val(result);

                    // Update the price based on result * data.price
                    var totalPrice = result * data.price;
                    // Round the total price to the nearest integer
                    var roundedPrice = Math.round(totalPrice);
                    row.find('.price-result').text(roundedPrice);

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
                        var qty = $(row).find('.qty-input').val();
                        var carton = $(row).find('.carton-input').val();
                        var inner = $(row).find('.inner-result').text().trim();
                        var unitPrice = $(row).find('.price').text().trim();
                        var netWeight = $(row).find('.net-weight').text().trim();
                        var priceAmount = $(row).find('.price-result').text().trim();

                        // Create hidden inputs and append to the form
                        $('#formDetailTransaction').append(`
    <!-- ID Detail Product (Validasi exists:detail_products,id) -->
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

                function updateAmounts() {
                    var totalCarton = 0;
                    var totalInner = 0;
                    var totalNetWeight = 0;
                    var PriceAmount = 0;

                    // Iterasi setiap baris untuk mendapatkan nilai total
                    $('#tableDetailTransaction tbody tr').each(function() {
                        var carton = parseFloat($(this).find('.carton-input').val()) || 0;
                        var inner = parseFloat($(this).find('.inner-result').text()) || 0;
                        var netWeight = parseFloat($(this).find('.net-weight').text()) || 0;
                        var price = parseFloat($(this).find('.price-result').text()) || 0;

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

                // Fungsi untuk memperbarui total price amount
                function updateTotals() {
                    // Ambil nilai dari Price Amount yang ada di kolom
                    var priceAmount = parseFloat($('#PriceAmount').text()) || 0;

                    // Ambil nilai dari input Freight Cost
                    var freightCost = parseFloat($('#freight_cost').val()) || 0;

                    // Hitung total dengan menambahkan priceAmount dan freightCost
                    var total = priceAmount + freightCost;

                    // Update elemen dengan total baru
                    $('#total').val(total);
                }

                // Event listener untuk input Freight Cost
                $('#freight_cost').on('input', function() {
                    updateTotals();
                });

                // Event handler untuk tombol "Hapus" pada #tableDetailTransaction
                $('#tableDetailTransaction tbody').on('click', '.remove-btn', function() {
                    $(this).closest('tr').remove(); // Menghapus baris saat tombol Hapus diklik

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

            // $('#submitButton').on('click', function() {
            //     $('#formTransaction').submit();
            // });

            $('#submitButton').click(function() {
                var formTransaction = $('#formTransaction');
                var formDetailTransaction = $('#formDetailTransaction');

                // Submit formTransaction terlebih dahulu
                $.ajax({
                    url: formTransaction.attr('action'),
                    method: formTransaction.attr('method'),
                    data: formTransaction.serialize(),
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
                                    alert(response.message);
                                    location
                                .reload(); // Reload halaman setelah alert
                                },
                                error: function(xhr) {
                                    // Tangani error untuk detail transaksi
                                    alert('Error saving detail transaction: ' + xhr
                                        .responseJSON.message);
                                }
                            });
                        } else {
                            alert('Transaction ID is missing');
                        }
                    },
                    error: function(xhr) {
                        // Tangani error untuk transaksi
                        alert('Error saving transaction: ' + xhr.responseJSON.message);
                    }
                });
            });

        });
    </script>
@endsection
