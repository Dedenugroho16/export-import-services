@extends('layouts.layout')
@section('title', 'Proforma Invoice')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Proforma Invoice -->
            <div class="mb-4">
                {{-- <a href="{{ route('proforma.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah
                </a> --}}
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#waitingProforma">
                    <i data-feather="search"></i>
                    Menunggu Persetujuan
                </button>
            </div>

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

            <!-- Daftar Proforma Invoice -->
            @if ($proformaInvoice->isEmpty())
                <p>Tidak ada proforma invoice yang tersedia.</p>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="approvedTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Number</th>
                                        <th class="text-center">Client ID</th>
                                        <th class="text-center">Consignee ID</th>
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

    <div class="modal fade text-left" id="waitingProforma" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Menunggu Persetujuan</h4>
                    <a href="{{ route('proforma.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Buat
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-2 mt-1">Daftar Proforma</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="waitingProformaTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Number</th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Consignee</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var approvedTable = $('#approvedTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('approved.data') }}',
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
                    [1, 'asc']
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }]
            });

            var table = $('#waitingProformaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('proforma.data') }}', // Endpoint yang memuat data
                    data: function(d) {
                        d.approved = 0; // Mengirimkan approved = 0 sebagai filter ke server
                    }
                },
                responsive: true,
                autoWidth: false,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'client',
                        name: 'client'
                    },
                    {
                        data: 'consignee',
                        name: 'consignee'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }]
            });

            // Handle approve button click with confirmation using SweetAlert
            $('#waitingProformaTable').on('click', '.approve-btn', function() {
                var transactionId = $(this).data('id');

                // Menampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak dapat membatalkan setelah ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna menekan tombol "Ya, Setujui!"
                        $.ajax({
                            url: '{{ route('proforma.approve', ':id') }}'.replace(':id',
                                transactionId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                            },
                            success: function(response) {
                                // Tampilkan pesan sukses dan reload tabel
                                Swal.fire(
                                    'Disetujui!',
                                    'Proforma invoice telah disetujui.',
                                    'success'
                                );
                                table.ajax.reload(); // Reload tabel setelah sukses
                                approvedTable.ajax
                            .reload(); // Reload tabel setelah sukses
                            },
                            error: function(xhr) {
                                // Tampilkan pesan error jika terjadi kesalahan
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan. Silakan coba lagi.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
