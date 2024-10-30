@extends('layouts.layout')
@section('title', 'Daftar Invoice')

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
                        className: 'text-center'
                    },
                    {
                        data: 'consignee',
                        name: 'consignee',
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [2, 'dsc']
                ], // Mengurutkan berdasarkan kolom pertama (No)
                pageLength: 10
            });
        });
    </script>
@endsection
