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

                            <form>
                                @csrf
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
                                                        <p>{{ date('F Y') }}</p>
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
                                                                    id="selectedClientName" placeholder="Pilih Client"
                                                                    readonly>
                                                                <input type="hidden" id="selectedClientId"
                                                                    name="id_client">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-primary btn-md"
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

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#PIModal">
                                                <i data-feather="search"></i> Cari proforma invoices
                                            </button>
                                        </div>
                                        <table class="table card-table table-vcenter text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">ID PI</th>
                                                    <th class="text-center">PI. NUMBER</th>
                                                    <th class="text-center">CODE</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">PAID</th>
                                                    <th class="text-center">BILL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-6">
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
                                </div>
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payments.index') }}"
                                    class="btn btn-outline-primary">Kembali</a>
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
                                            <th class="text-center">ID PI</th>
                                            <th class="text-center">PI. NUMBER</th>
                                            <th class="text-center">CODE</th>
                                            <th class="text-center">DESCRIPTION</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">PAID</th>
                                            <th class="text-center">BILL</th>
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
            }

            updateNumber();
        });
    </script>
@endsection
