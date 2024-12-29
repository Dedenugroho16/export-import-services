@extends('layouts.layout')
@section('title', 'Bill of Payment')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Bill of Payment</h3>
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Month</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p>{{ strtoupper(date('F Y')) }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>No. Inv</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p id="no-inv-display">-</p>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select name="id_client" id="client_id"
                                                                class="form-control select2">
                                                                <option value="">Pilih Buyer</option>
                                                            </select>
                                                        </div>
                                                        <span class="error-message" id="selectedClientId_error"
                                                            style="color: red; display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <p>Company Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                id="selectedClientCompanyName"
                                                                placeholder="Pilih Perusahaan Client" readonly>
                                                            
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-md"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#clientCompanyModal">
                                                                    <i data-feather="search"></i> Cari
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span class="error-message" id="selectedConsigneeId_error"
                                                            style="color: red; display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formTransaction" action="{{ route('desc-bills.store') }}">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#PIModal">
                                                <i data-feather="search"></i> Cari proforma invoices
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="error-message" id="pi_error"
                                            style="color: red; display: none;"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <table class="table table-striped table-hover" id="billOfPaymentTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">PI. NUMBER</th>
                                                    <th class="text-center">CODE</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">PAID</th>
                                                    <th class="text-center">BILL</th>
                                                    <th class="text-center">AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-end" colspan="5">
                                                        <label for="total" class="mr-2">AMOUNT OF BILL:</label>
                                                    </td>
                                                    <td class="text-center" style="width: 150px;">
                                                        <div
                                                            class="form-group d-flex align-items-center justify-content-center">
                                                            <input type="text" step="0.01"
                                                                class="form-control total-display" readonly>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </form>

                            <form id="formBOP" class="mt-2" method="POST"
                                action="{{ route('bill-of-payment.store') }}">
                                @csrf
                                <input type="hidden" id="month" name="month">
                                <input type="hidden" id="no_inv" name="no_inv">
                                <input type="hidden" id="selectedClientId" name="id_client">
                                <input type="hidden" id="selectedClientCompanyId" name="id_client_company">
                                <input type="hidden" id="total" name="total">
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payment.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Buat</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="modal fade text-left" id="PIModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Proforma Invoices</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="PITable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">PI. NUMBER</th>
                                            <th class="text-center">CODE</th>
                                            <th class="text-center">PAID</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">AKSI</th>
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

        $(document).ready(function() {
            // Event listener untuk select client
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                var clientName = $('#client_id option:selected').text();

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyId').val('');
                $('#selectedClientCompanyName').val('');

                // Memuat data consignee berdasarkan ID client yang dipilih
                loadClientCompanies(clientId);
            });

            var clientCompanyTable = $('#clientCompanyModalTable').DataTable({
                autoWidth: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('clientCompanies.byClient', ['clientId' => 0]) }}", // Initial empty clientId
                    dataSrc: function(json) {
                        if (json.data.length === 0) {
                            if ($('#selectedClientId').val() === '' || $('#selectedClientId').val() ===
                                '0') {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Harap pilih client terlebih dahulu";
                            } else {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Tidak ada client company untuk client ini";
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
                            return `<div class="text-center">
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

            window.loadClientCompanies = function(clientId) {
                if (!clientId || clientId === '0') {
                    clientCompanyTable.ajax.url(
                        "{{ route('clientCompanies.byClient', ['clientId' => ':clientId']) }}".replace(
                            ':clientId', clientId)).load();
                    return;
                }

                clientCompanyTable.ajax.url(
                    "{{ route('clientCompanies.byClient', ['clientId' => ':clientId']) }}".replace(
                        ':clientId', clientId)).load();
            };


            // Event listener for opening the client company modal
            $('#openClientCompanyModal').on('click', function() {
                var clientId = $('#selectedClientId').val();

                if (!clientId) {
                    clientCompanyTable.ajax.url(
                        "{{ route('clientCompanies.byClient', ['clientId' => 0]) }}").load();
                }

                $('#clientCompanyModal').modal('show');
            });

            // Event listener for selecting a client company from the modal
            $('#clientCompanyModalTable tbody').on('click', '.select-client-company', function() {
                var clientCompanyId = $(this).data('id');
                var clientCompanyName = $(this).data('name');

                $('#selectedClientCompanyId').val(clientCompanyId);
                $('#selectedClientCompanyName').val(clientCompanyName);
                $('#clientCompanyModal').modal('hide');
            });
        });

        $(document).ready(function() {
            // Event listener untuk select client
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                var clientName = $('#client_id option:selected').text();

                // Menetapkan nilai pada inputan yang relevan
                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyId').val('');
                $('#selectedClientCompanyName').val('');

                // Memuat data proforma invoice berdasarkan ID client yang dipilih
                loadProformaInvoices(clientId);
            });

            // Function untuk memuat proforma invoices berdasarkan clientId
            function loadProformaInvoices(clientId) {
                $('#PITable').DataTable().ajax.url("{{ route('getProformaInvoices') }}?id_client=" + clientId)
                    .load();
            }

            // Inisialisasi DataTable untuk #PITable
            var proformaInvoiceTable = $('#PITable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getProformaInvoices') }}", // Route untuk mengambil data
                    type: 'GET',
                    data: function(d) {
                        var clientId = $('#selectedClientId').val();
                        d.id_client = clientId ? clientId : null;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'number',
                        name: 'number',
                        className: 'text-center'
                    },
                    {
                        data: 'code',
                        name: 'code',
                        className: 'text-center'
                    },
                    {
                        data: 'total_paid',
                        name: 'total_paid',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `<button class="btn btn-primary btn-sm pilih-btn" 
                    data-id="${row.id}" 
                    data-number="${row.number}"
                    data-paid="${row.total_paid}" 
                    data-code="${row.code}" 
                    data-amount="${row.amount}">
                    Pilih
                    </button>`;
                        }
                    }
                ],
                language: {
                    decimal: ".",
                    thousands: ",",
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
                        var clientSelected = $('#selectedClientId').val();
                        return clientSelected ?
                            "Buyer yang Anda pilih tidak memiliki tagihan" :
                            "Tolong pilih buyer terlebih dahulu";
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
                order: [
                    [2, 'desc']
                ],
                pageLength: 10
            });

            // Event listener untuk tombol "Pilih"
            var selectedPI = []; // Array untuk menyimpan ID yang sudah dipilih

            $('#PITable tbody').on('click', '.pilih-btn', function() {
                // Ambil data dari tombol yang diklik
                var data = $(this).data();

                // Periksa apakah ID sudah ada di selectedPI
                if (selectedPI.includes(data.id)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal Menambahkan!',
                        text: 'Proforma invoice ini sudah dipilih. Silakan pilih proforma invoice lain.',
                        confirmButtonText: 'OK'
                    });
                    $('#PIModal').modal('hide'); // Menutup modal jika produk sudah dipilih
                    return;
                }

                // Jika ID belum ada, tambahkan ke array selectedPI
                selectedPI.push(data.id);

                // Tambahkan baris baru ke tabel #billOfPaymentTable
                var formattedAmount = parseFloat(data.amount).toLocaleString('en-US');
                var formattedBill = parseFloat(data.amount - data.paid).toLocaleString('en-US');
                var newRow = `
            <tr>
                <td class="text-center" style="display: none;">
                    <input class="id-proforma" type="hidden" name="transactions[${data.id}][id]" value="${data.id}">
                </td>
                <td class="text-center" style="display: none;">
                    <input type="hidden" id="id_bill" name="transactions[${data.id}][id_bill]">
                </td>
                <td class="text-center">${data.number}</td>
                <td class="text-center">${data.code}</td>
                <td class="text-center">
                    <input type="text" name="transactions[${data.id}][description]" class="form-control description-input" placeholder="Enter description">
                </td>
                <td class="text-center amount">${formattedAmount}</td>
                <td class="text-center" style="width:150px;">
                    <input type="text" class="form-control" value="${data.paid?.toLocaleString('en-US')}" readonly>
                    <input type="hidden" name="transactions[${data.id}][paid]" class="form-control" value="${data.paid}">
                </td>
                <td class="text-center pi-bill">
                    <input type="text" class="form-control bill-input" placeholder="Enter bill">
                    <input type="hidden" name="transactions[${data.id}][bill]" class="form-control bill-hidden">
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm delete-btn">Hapus</button>
                </td>
            </tr>
        `;

                // Append row ke #billOfPaymentTable
                $('#billOfPaymentTable tbody').append(newRow);
                $('#pi_error').text('Data Proforma Invoice harus diisi!').hide();

                // Menutup modal setelah produk dipilih
                $('#PIModal').modal('hide');

                // Event listener untuk tombol "Hapus"
                $('#billOfPaymentTable').on('click', '.delete-btn', function() {
                    var row = $(this).closest('tr');
                    var idToRemove = row.find('.id-proforma').val();

                    // Hapus produk dari array selectedPI jika dihapus
                    var index = selectedPI.indexOf(parseInt(idToRemove));
                    if (index !== -1) {
                        selectedPI.splice(index, 1);
                    }

                    row.remove(); // Hapus baris dari tabel
                    totalBill();
                });

                totalBill();
            });

            // Function untuk menghitung total bill
            function totalBill() {
                var totalBill = 0;

                // Iterasi setiap baris untuk mendapatkan nilai total
                $('#billOfPaymentTable tbody tr').each(function() {
                    var bill = parseFloat($(this).find('.bill-hidden').val()) ||
                        0; // Ambil nilai asli dari .bill-hidden
                    totalBill += bill;
                });

                // Hitung grandTotal
                var grandTotal = totalBill;

                var formattedGrandTotal = grandTotal.toLocaleString('en-US', {
                    minimumFractionDigits: 2
                });

                // Update nilai total di elemen input total-display
                $('.total-display').val(formattedGrandTotal);
                $('#total').val(grandTotal);
            }

            // Event listener untuk input bill
            $('#billOfPaymentTable tbody').on('input', '.bill-input', function() {
                var row = $(this).closest('tr');
                var billInput = $(this);

                // Ambil nilai input dan hapus karakter selain angka
                var value = billInput.val();
                var numericValue = value.replace(/[^0-9]/g, '');

                // Format nilai ke locale string
                var formattedValue = parseFloat(numericValue || 0).toLocaleString('en-US');
                billInput.val(formattedValue);

                // Simpan nilai asli (angka saja) ke dalam input hidden .bill-hidden
                row.find('.bill-hidden').val(numericValue);

                totalBill();
                // Validasi jika diperlukan (contoh kasus transfer lebih besar dari jumlah tagihan)
                var piBill = parseFloat(row.find('.pi-bill input').val().replace(/,/g, '')) || 0;
                var payment = parseFloat(numericValue) || 0;

                if (payment > piBill) {
                    $('#submitButton').prop('disabled', true); // Disable tombol submit
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Transfer Tidak Valid',
                        text: 'Nilai transfer tidak boleh lebih besar dari jumlah yang harus dibayar.',
                    });
                } else {
                    $('#submitButton').prop('disabled', false); // Aktifkan tombol jika valid
                }
            });

            function updateNumber() {
                const currentDate = new Date();

                // Dapatkan bulan dalam format angka Romawi
                const romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                const romanMonth = romanMonths[currentDate.getMonth()];

                // Dapatkan tahun dalam format dua digit
                const twoDigitYear = currentDate.getFullYear().toString().slice(-2);

                const formattedNumber = '/INV/' + romanMonth + '/' +
                    twoDigitYear;
                const finalNumber = '{{ $formattedNumber }}' + formattedNumber;
                $('#no-inv-display').text(finalNumber);
                $('#no_inv').val(finalNumber);
            }

            updateNumber();

            // Mendapatkan bulan dan tahun saat ini
            var currentDate = new Date();
            var options = {
                year: 'numeric',
                month: 'long'
            };
            var monthYear = currentDate.toLocaleDateString('id-ID', options).toUpperCase();

            // Menetapkan nilai input #month
            $('#month').val(monthYear);

        });


        $(document).ready(function() {
            function validateTransactionForm() {
                var isValid = true;

                // Cek semua input di dalam tabel kecuali yang memiliki id="id_bill"
                var inputs = $('#billOfPaymentTable tbody input').not('#id_bill');

                if (inputs.length === 0) {
                    isValid = false; // Jika tidak ada input selain id_bill
                    $('#pi_error').text('Data Proforma Invoice harus diisi!').show();
                } else {
                    inputs.each(function() {
                        if ($(this).val().trim() === '') { // Jika ada input kosong
                            isValid = false;
                            $('#pi_error').text('Semua input harus diisi!').show();
                            return false; // Keluar dari loop each lebih awal
                        }
                    });
                }

                return isValid; // Kembalikan status validasi
            }

            $('#submitButton').on('click', function() {
                var formBOP = $('#formBOP');
                var formDataBOP = formBOP.serialize(); // Serialize form data

                // Disable the submit button to prevent multiple submissions
                $(this).prop('disabled', true);

                var selectedClientId = $('#selectedClientId').val();
                if (!selectedClientId) {
                    $('#selectedClientId_error').text('Data Buyer harus diisi').show();
                    $('#selectedClientName').addClass('is-invalid'); // Tambah border merah pada input
                    $('.input-group').addClass('has-error'); // Tambah border merah pada grup input
                }

                var selectedClientCompanyId = $('#selectedClientCompanyId').val();
                if (!selectedClientCompanyId) {
                    $('#selectedClientCompanyId_error').text('Data perusahaan harus diisi').show();
                    $('#selectedClientCompanyName').addClass('is-invalid'); // Tambah border merah pada input
                    $('.input-group').addClass('has-error'); // Tambah border merah pada grup input
                }

                var isValidDetailTransaction = validateTransactionForm();

                if (!isValidDetailTransaction) {
                    $('#submitButton').prop('disabled', false);
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: 'Mohon lengkapi data Bill of Payment!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan proses jika form detail transaksi tidak valid
                }

                // Submit formBOP via AJAX
                $.ajax({
                    url: formBOP.attr('action'), // The action URL from the formBOP
                    method: 'POST',
                    data: formDataBOP,
                    success: function(response) {
                        if (response.success) {
                            // Capture the returned id_bill from the response
                            var idBill = response.id_bill;

                            // Now process formTransaction by appending the rows with the id_bill
                            var formTransaction = $('#formTransaction');
                            $('#billOfPaymentTable tbody tr').each(function() {
                                // For each row in the table, set the id_bill for the hidden input
                                $(this).find('input[name^="transactions"]').each(
                                    function() {
                                        if ($(this).attr('name').includes(
                                                'id_bill')) {
                                            $(this).val(
                                                idBill); // Set the value of id_bill
                                        }
                                    });
                            });

                            // Submit formTransaction via AJAX after setting id_bill
                            var formDataTransaction = formTransaction
                                .serialize(); // Serialize form data
                            $.ajax({
                                url: formTransaction.attr(
                                    'action'), // The action URL from formTransaction
                                method: 'POST',
                                data: formDataTransaction,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: response
                                                .message, // Menampilkan pesan dari server
                                        }).then(function() {
                                            window.location.href =
                                                '{{ route('bill-of-payment.index') }}'; // Redirect ke halaman yang diinginkan
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal Menyimpan Transaksi!',
                                            text: response.message ||
                                                'Terjadi kesalahan saat menyimpan transaksi.',
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan!',
                                        text: 'Gagal mengirimkan Proforma Invoice.',
                                    });
                                }
                            });

                        } else {
                            $(this).prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal membuat Bill of Payment!',
                                text: response.message ||
                                    'Terjadi kesalahan saat membuat Bill of Payment.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Periksa kembali inputan Anda';

                        // Periksa apakah server mengembalikan error dalam format JSON
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            // Jika format bukan JSON, gunakan responseText
                            errorMessage = xhr.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: errorMessage,
                        });
                    },
                    complete: function() {
                        // Aktifkan kembali tombol setelah selesai (sukses/gagal)
                        $('#submitButton').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
