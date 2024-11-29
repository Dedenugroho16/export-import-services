@extends('layouts.layout')
@section('title', 'Proforma Invoices')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Proforma Invoice -->
            <div class="mb-4">
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#waitingProforma">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path
                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                    </svg>
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
                        <h3>Daftar Proforma Disetujui</h3>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="approvedTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode</th>
                                        <th class="text-center">Number</th>
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

    <div class="modal fade text-left" id="waitingProforma" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Menunggu Persetujuan</h4>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
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
                    @endif
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
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Number</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Client</th>
                                            <th class="text-center">Consignee</th>
                                            <th class="text-center">Aksi</th>
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
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'code', name: 'code', className: 'text-center' },
                    { data: 'number', name: 'number', className: 'text-center' },
                    { data: 'client', name: 'client' },
                    { data: 'consignee', name: 'consignee' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
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
                order: [[2, 'dsc']], 
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }],
                drawCallback: function() {
                    // Terapkan style khusus untuk kolom client dan consignee
                    $('#approvedTable td:nth-child(4), #approvedTable th:nth-child(4)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#approvedTable td:nth-child(5), #approvedTable th:nth-child(5)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });

            var table = $('#waitingProformaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('proforma.data') }}',
                    data: function(d) {
                        d.approved = 0;
                    }
                },
                responsive: true,
                autoWidth: false,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'code', name: 'code', class: 'text-center' },
                    { data: 'number', name: 'number', class: 'text-center' },
                    { data: 'date', name: 'date', class: 'text-center' },
                    { data: 'client', name: 'client' },
                    { data: 'consignee', name: 'consignee' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false, class: 'text-center'}
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
                order: [[2, 'dsc']],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }],
                drawCallback: function() {
                    // Terapkan style khusus untuk kolom client dan consignee
                    $('#waitingProformaTable td:nth-child(5), #waitingProformaTable th:nth-child(5)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                    $('#waitingProformaTable td:nth-child(6), #waitingProformaTable th:nth-child(6)').css({
                        'max-width': '200px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });

            $('#waitingProformaTable').on('click', '.approve-btn', function() {
            var transactionId = $(this).data('id');
            var userSignatureUrl = '{{ auth()->user()->signature_url }}'; // Ambil URL tanda tangan pengguna

            if (!userSignatureUrl) {
                // Jika signature_url kosong, tampilkan alert dan tombol untuk menuju halaman profil
                Swal.fire({
                    title: 'Lengkapi Profil Anda',
                    text: "Anda harus melengkapi tanda tangan untuk menyetujui Proforma invoice.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ke Profil',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("profile.show") }}';
                    }
                });
            } else {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak dapat membatalkan setelah ini!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('proforma.approve', ':id') }}'.replace(':id', transactionId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Disetujui!',
                                    'Proforma invoice telah disetujui.',
                                    'success'
                                );
                                table.ajax.reload();
                                approvedTable.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Anda tidak memiliki akses untuk menyetujui Proforma.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        });

        });
    </script>
@endsection
