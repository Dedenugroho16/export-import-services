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
                                                            <option value="{{ $client->id }}"
                                                                data-address="{{ $client->address }}">{{ $client->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <!-- Element to display the address -->
                                                    <div id="client-address" style="margin-top: 10px;"></div>
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
                                                    <th class="text-center">Aksi</th>
                                                </thead>
                                                <tbody style="font-size: 12px">
                                                    <tr id="nullDetailTransaction">
                                                        <td colspan="11" class="text-center">Tidak ada barang</td>
                                                    </tr>
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
            // Menginisialisasi Select2
            $('#client').select2();
            $('#consignee').select2();
            $('#product').select2();
            $('#commodity').select2();

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
        // $(document).ready(function() {
        //     var table = $('#detailProductTable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ route('get-detail-products') }}",
        //             data: function(d) {
        //                 var productId = $('#product').val();
        //                 if (productId) {
        //                     d.id_product = productId; // Kirim nilai id_product jika dipilih
        //                 } else {
        //                     d.id_product = null; // Tidak ada produk yang dipilih
        //                 }
        //             }
        //         },
        //         columns: [{
        //                 data: 'id',
        //                 name: 'id'
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name'
        //             },
        //             {
        //                 data: 'pcs',
        //                 name: 'pcs'
        //             },
        //             {
        //                 data: 'dimension',
        //                 name: 'dimension'
        //             },
        //             {
        //                 data: 'type',
        //                 name: 'type'
        //             },
        //             {
        //                 data: 'color',
        //                 name: 'color'
        //             },
        //             {
        //                 data: 'price',
        //                 name: 'price'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ],
        //         language: {
        //             emptyTable: function() {
        //                 if ($('#product').val()) {
        //                     return "Produk yang Anda pilih tidak memiliki detail produk"; // Pesan ketika produk tidak memiliki detail produk
        //                 } else {
        //                     return "Tolong pilih produk terlebih dahulu"; // Pesan ketika produk belum dipilih
        //                 }
        //             },
        //             "decimal": ",",
        //             "thousands": ".",
        //             "lengthMenu": "Tampilkan _MENU_ entri",
        //             "zeroRecords": "Tidak ada data yang ditemukan",
        //             "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        //             "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
        //             "infoFiltered": "(disaring dari _MAX_ total entri)",
        //             "search": "Cari:",
        //             "paginate": {
        //                 "first": "Pertama",
        //                 "last": "Terakhir",
        //                 "next": "Selanjutnya",
        //                 "previous": "Sebelumnya"
        //             },
        //             "loadingRecords": "Sedang memuat...",
        //             "processing": "Sedang memproses...",
        //             "emptyTable": "Tidak ada data yang tersedia di tabel",
        //             "aria": {
        //                 "sortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
        //                 "sortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
        //             },
        //             "select": {
        //                 "rows": {
        //                     "_": "%d baris terpilih",
        //                     "1": "1 baris terpilih"
        //                 }
        //             }
        //         },
        //         responsive: true,
        //         autoWidth: false,
        //         lengthMenu: [5, 10, 25, 50],
        //         pageLength: 10
        //     });

        //     // Event ketika user memilih produk
        //     $('#product').change(function() {
        //         if ($(this).val()) {
        //             // Jika produk dipilih, reload DataTables dengan data produk
        //             table.ajax.reload();
        //         } else {
        //             // Jika produk belum dipilih, kosongkan DataTables dan tampilkan pesan
        //             table.clear().draw(); // Clear table
        //         }
        //     });
        // });

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

            // Event handler ketika tombol "Pilih" diklik
            $('#detailProductTable tbody').on('click', '.pilih-btn', function() {
                var data = table.row($(this).parents('tr'))
                    .data(); // Mengambil data dari baris yang dipilih

                // Membuat elemen tr untuk ditambahkan ke tabel #tableDetailTransaction
                var newRow = `
        <tr>
            <td class="text-center">
        <strong>${data.name} ${data.pcs} PCS / 12 KG</strong><br>
        ${data.dimension} ${data.color} - ${data.type}
    </td>
            <td class="text-center">${data.pcs}</td>
            <td class="text-center">${data.dimension}</td>
            <td class="text-center">${data.price}</td>
            <td class="text-center">${data.color}</td>
            <td class="text-center">${data.price}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm remove-btn">Hapus</button>
            </td>
        </tr>`;

                // Menambahkan elemen tr baru ke tabel #tableDetailTransaction
                $('#tableDetailTransaction tbody').append(newRow);

                // Menghapus baris "Tidak ada barang" jika ada
                $('#nullDetailTransaction').remove();
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
            });
        });
    </script>
@endsection
