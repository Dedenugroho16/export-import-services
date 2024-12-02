@extends('layouts.layout')
@section('title', 'Opening Balance')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Opening Balance</h3>
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
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                id="selectedClientName" placeholder="Pilih Buyer" readonly>
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

                            <form id="formBOP" class="mt-3 p-3 bg-light rounded shadow-sm" method="POST"
                                action="{{ route('opening-balance.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="no_inv" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="no_inv" name="no_inv"
                                        placeholder="Enter Invoice Number">
                                </div>

                                <div class="mb-3">
                                    <label for="total" class="form-label">Payment</label>
                                    <input type="number" class="form-control" id="total" name="total"
                                        placeholder="Enter Payment">
                                </div>

                                <input type="hidden" id="month" name="month">
                                <input type="hidden" class="form-control" id="selectedClientId" name="id_client">
                                <input type="hidden" class="form-control" id="selectedClientCompanyId"
                                    name="id_client_company">

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
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
                                <th class="text-center">ID Perusahaan</th>
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
                        data: 'company_id',
                        name: 'company_id',
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
                            console.log(row);
                            return `<button class="btn btn-primary select-client" data-id="${row.id}" data-name="${row.name}" data-company="${row.company_name}" data-idcompany="${row.company_id}">Pilih</button>`;
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
                        'max-width': '250px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#clientsModalTable td:nth-child(3), #clientsModalTable td:nth-child(4)').css({
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
                var companyName = $(this).data('company');
                var companyID = $(this).data('idcompany');

                $('#selectedClientId').val(clientId);
                $('#selectedClientCompanyId').val(companyID);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyName').val(companyName);
                $('#clientsModal').modal('hide');

                $('#selectedClientId_error').text('').hide(); // Sembunyikan pesan error
                $('#selectedClientName').removeClass('is-invalid'); // Hapus border merah pada input
                $('.input-group').removeClass('has-error'); // Hapus border merah pada grup input
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
    </script>
@endsection
