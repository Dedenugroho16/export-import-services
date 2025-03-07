@extends('layouts.layout')
@section('title', 'Opening Balance')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                @if (in_array(auth()->user()->role, ['admin', 'finance']))
                    <a href="{{ route('opening-balance.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-plus">
                            <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Tambah
                    </a>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <h3>Daftar Opening Balance</h3>
                    <div class="table-responsive">
                        <table id="openingBalanceTable" class="table card-table table-hover table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Deskripsi</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama Client</th>
                                    <th class="text-center">Nama Perusahaan</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Dibuat Oleh</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script DataTables -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Ambil role pengguna dari server (bisa dimasukkan ke dalam meta tag)
            var userRole = "{{ auth()->user()->role }}";

            // Tentukan apakah kolom Aksi harus ditampilkan
            var showActionColumn = (userRole === 'admin' || userRole === 'finance');

            var table = $('#openingBalanceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('opening-balance.index') }}",
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
                        data: 'payment_number',
                        name: 'payment_number'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        class: 'text-center'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'client_company_name',
                        name: 'client_company_name'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        class: 'text-center',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: 'created_by_name',
                        name: 'created_by_name',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        class: 'text-center',
                        orderable: false,
                        searchable: false,
                        visible: showActionColumn // Sembunyikan jika role bukan admin/finance
                    }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ Data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
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
                    // Terapkan style khusus untuk kolom client dan consignee
                    $('#openingBalanceTable td:nth-child(4), #openingBalanceTable td:nth-child(5)')
                .css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#openingBalanceTable td:nth-child(2)').css({
                        'max-width': '200',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });

            // Hilangkan kolom aksi dari header jika tidak ditampilkan
            if (!showActionColumn) {
                $('.aksi-column').hide();
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-dismissible').fadeOut();
            }, 3000);
        });
    </script>
@endsection
