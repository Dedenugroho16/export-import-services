@extends('layouts.layout')
@section('title', 'Final Invoices')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Pesan Sukses (Jika ada) -->
            @if (session('success'))
                <div class="alert alert-important alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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

            <!-- Daftar Invoice -->
            @if ($transactions->isEmpty())
                <p>Tidak ada invoice yang tersedia.</p>
            @else
                <div class="card">
                    <div class="card-body">
                        <h3>Daftar Final Invoices</h3>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="invoiceTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Number</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Client</th>
                                        <th class="text-center">Consignee</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#invoiceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getInvoice') }}", // Route untuk mengambil data
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'code',
                        name: 'code',
                        className: 'text-center'
                    },
                    {
                        data: 'number',
                        name: 'number',
                        className: 'text-center'
                    },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    {
                        data: 'client',
                        name: 'client',
                    },
                    {
                        data: 'consignee',
                        name: 'consignee',
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
                order: [
                    [2, 'dsc']
                ], // Mengurutkan berdasarkan kolom pertama (No)
                pageLength: 10,
                drawCallback: function() {
                    // Terapkan style khusus untuk kolom client dan consignee
                    $('#invoiceTable td:nth-child(5), #invoiceTable th:nth-child(5)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#invoiceTable td:nth-child(6), #invoiceTable th:nth-child(6)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });
        });
    </script>
@endsection
