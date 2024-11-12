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
                                        <div class="col-6">
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
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                id="selectedClientName" placeholder="Pilih Client" readonly>
                                                            <br>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-md"
                                                                    data-bs-toggle="modal" data-bs-target="#clientsModal">
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
                                                <div class="col-4">
                                                    <p>Company Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <input type="text" class="form-control"
                                                        id="selectedClientCompanyName" placeholder="Nama Perusahaan"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="" id="formTransaction">
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
                                        </table>
                                    </div>
                                </div>

                                {{-- <div class="row mt-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <h3>REMITTANCE ADVICE</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Account Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p>{{ date('F Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Account Number USD</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="product-code">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Bank Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Bank Address</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Swift Code</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </form>

                            <form action="" id="formBOP" class="mt-2">
                                <input type="" id="month" name="month">
                                <input type="" id="no_inv" name="no_inv">
                                <input type="" id="selectedClientId" name="id_client">
                                <input type="" id="total" name="total">

                                <select name="status">
                                    <option value="">Status pembayaran</option>
                                    <option value="0">Belum Lunas</option>
                                    <option value="1">Lunas</option>
                                </select>

                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payments.index') }}" class="btn btn-outline-primary">Kembali</a>
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
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">Alamat</th>
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
                        name: 'name',
                        class: 'text-center'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                        class: 'text-center'
                    },
                    {
                        data: 'address',
                        name: 'address',
                        class: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button class="btn btn-primary select-client" data-id="${row.id}" data-name="${row.name}" data-company="${row.company_name}">Pilih</button>`;
                        },
                        class: 'text-center',
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
                        'max-width': '280px',
                        'overflow': 'hidden',
                        'text-overflow': 'ellipsis'
                    });
                }
            });

            // Event listener untuk tombol "Pilih" di tabel client
            $('#clientsModalTable tbody').on('click', '.select-client', function() {
                var clientId = $(this).data('id');
                var clientName = $(this).data('name');
                var companyName = $(this).data('company');

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyName').val(companyName);
                $('#clientsModal').modal('hide');

                $('#PITable').DataTable().ajax.reload();
            });

            // Inisialisasi DataTable untuk #PITable
            $('#PITable').DataTable({
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
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            // Simpan ID transaksi di data-id tanpa menampilkan kolom ID di tabel
                            return `<button class="btn btn-primary btn-sm pilih-btn" 
                        data-id="${row.id}" 
                        data-number="${row.number}" 
                        data-code="${row.code}" 
                        data-amount="${row.amount}">
                        Pilih
                        </button>`;
                        }
                    }
                ],
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
                var newRow = `
        <tr>
            <td class="text-center" style="display: none;">
                <input type="text" class="form-control id-proforma" value="${data.id}">
            </td>
            <td class="text-center" style="display: none;">
                <input type="text" class="form-control" name="id_bill" id="id_bill">
            </td>
            <td class="text-center">${data.number}</td>
            <td class="text-center">${data.code}</td>
            <td class="text-center">
                <input type="text" name="description" id="description" class="form-control description-input" placeholder="Enter description">
            </td>
            <td class="text-center">${data.amount}</td>
            <td class="text-center">
                <input type="number" name="paid" id="paid" class="form-control paid-input" placeholder="Enter paid" style="width: 120px;">
            </td>
            <td class="text-center">${data.amount}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm delete-btn">Hapus</button>
            </td>
        </tr>
    `;

                // Append row ke #billOfPaymentTable
                $('#billOfPaymentTable tbody').append(newRow);

                // Menutup modal setelah produk dipilih
                $('#PIModal').modal('hide');
            });

            // Event listener untuk tombol "Hapus"
            $('#billOfPaymentTable').on('click', '.delete-btn', function() {
                var row = $(this).closest('tr');
                var idToRemove = row.find('.id-proforma').val();

                // Hapus produk dari array newSelectedProductIds jika dihapus
                var index = selectedPI.indexOf(parseInt(idToRemove));
                if (index !== -1) {
                    selectedPI.splice(index, 1);
                }

                row.remove(); // Hapus baris dari tabel
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
            var monthYear = currentDate.toLocaleDateString('id-ID', options)
                .toUpperCase(); // Menggunakan 'id-ID' untuk format bahasa Indonesia dan toUpperCase untuk huruf kapital

            // Menetapkan nilai input #month
            $('#month').val(monthYear);
        });
    </script>
@endsection
