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

                            {{-- Bagian 1 --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">INVOICE - NUMBER</h3>
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
                                                            <p>{{ date('d F Y') }}</p>
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
                                                            <p>-</p>
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
                                                            <p>-</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form>
                                @csrf

                                <!-- Bagian 2: Consignee, Notify, Client -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Parties Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <select class="form-control client" id="client">
                                                        <option value="">Pilih Client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="notify">Notify</label>
                                                    <input type="text" id="notify" class="form-control"
                                                        placeholder="Enter notify party">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="consignee">Consignee</label>
                                                    <select class="form-control consignee" id="consignee">
                                                        <option value="">Pilih Consignee</option>
                                                    </select>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_loading">Port of Loading</label>
                                                    <input type="text" id="port_of_loading" class="form-control"
                                                        placeholder="Enter port of loading">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_receipt">Place of Receipt</label>
                                                    <input type="text" id="place_of_receipt" class="form-control"
                                                        placeholder="Enter place of receipt">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_discharge">Port of Discharge</label>
                                                    <input type="text" id="port_of_discharge" class="form-control"
                                                        placeholder="Enter port of discharge">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_delivery">Place of Delivery</label>
                                                    <input type="text" id="place_of_delivery" class="form-control"
                                                        placeholder="Enter place of delivery">
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
                                                        <select class="form-control product" id="product">
                                                            <option value="">Pilih Product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->name }}
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
                                                        <select class="form-control commodity" id="commodity">
                                                            <option value="">Pilih Commodity</option>
                                                            @foreach ($commodities as $commodity)
                                                                <option value="{{ $commodity->id }}">{{ $commodity->name }}
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
                                                            class="form-control" placeholder="Masukkan Container">
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
                                                        <input type="number" id="decimalInput" name="decimalInput"
                                                            class="form-control" step="0.01"
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
                                                        <input type="number" id="decimalInput" name="decimalInput"
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
                                                        <input type="text" name="container" id="container"
                                                            class="form-control" placeholder="Masukkan Payment term">
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
                            </form>

                            <form>
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
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item Description</th>
                                                        <th>Carton (pcs)</th>
                                                        <th>Inner (pcs)</th>
                                                        <th>Unit Price (USD / KG)</th>
                                                        <th>Net Weight (KG)</th>
                                                        <th>Price Amount (USD)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="item_description[]" placeholder="Item Description">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="carton_pcs[]" placeholder="Carton (pcs)">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="inner_pcs[]"
                                                                placeholder="Inner (pcs)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="unit_price[]" placeholder="Unit Price (USD / KG)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="net_weight[]" placeholder="Net Weight (KG)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="price_amount[]" placeholder="Price Amount (USD)">
                                                        </td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Tombol Submit -->
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-primary">Submit Invoice</button>
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
                                            <th>Product Name</th>
                                            <th>Pcs</th>
                                            <th>Dimension</th>
                                            <th>Type</th>
                                            <th>Color</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#client').select2(); // Menginisialisasi Select2 untuk client
            $('#consignee').select2(); // Menginisialisasi Select2 untuk consignee
            $('#product').select2(); // Menginisialisasi Select2 untuk product
            $('#commodity').select2(); // Menginisialisasi Select2 untuk commodity

            // Ketika client dipilih
            $('#client').on('change', function() {
                var clientId = $(this).val(); // Ambil ID client yang dipilih

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
                                    .id + '">' + consignee.name + '</option>');
                            });

                            // Refresh Select2 setelah data diperbarui
                            $('#consignee').trigger('change');
                        }
                    });
                } else {
                    $('#consignee').empty();
                    $('#consignee').append('<option value="">Pilih Consignee</option>');
                }
            });
        });

        // DATATABLES
        //     $(document).ready(function() {
        //     var table = $('#detailProductTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('get-detail-products') }}",
        //         columns: [
        //             { data: 'id', name: 'id' },
        //             { data: 'name', name: 'name' },
        //             { data: 'pcs', name: 'pcs' },
        //             { data: 'dimension', name: 'dimension' },
        //             { data: 'type', name: 'type' },
        //             { data: 'color', name: 'color' },
        //             { data: 'price', name: 'price' },
        //             { data: 'action', name: 'action', orderable: false, searchable: false }
        //         ]
        //     });

        //     // Load DataTables when modal is shown
        //     $('#memberModal').on('shown.bs.modal', function () {
        //         table.ajax.reload(null, false); // Reload data without resetting the table
        //     });
        // });

        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#detailProductTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get-detail-products') }}", // Ganti dengan URL route kamu
                    data: function(d) {
                        d.id_product = $('#product').val(); // Kirim nilai id_product dari dropdown
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pcs',
                        name: 'pcs'
                    },
                    {
                        data: 'dimension',
                        name: 'dimension'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                autoWidth: false, // Tidak secara otomatis mengatur lebar kolom
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari produk...",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri"
                },
                lengthMenu: [5, 10, 25, 50], // Menentukan jumlah data yang ditampilkan per halaman
                pageLength: 10 // Jumlah default data yang ditampilkan
            });

            // Event ketika user memilih product
            $('#product').change(function() {
                table.ajax.reload(); // Reload DataTables dengan filter baru
            });
        });
    </script>
@endsection
