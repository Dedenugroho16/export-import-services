@extends('layouts.layout')

@section('title', 'Data Cabang')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('branches.create')}}" class="btn btn-primary">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah
            </a>
        </div>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="branchesTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama Cabang</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk DataTables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#branchesTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: "{{ route('branches.index') }}",
            autoWidth: false,
            columns: [
                { data: 'id', name: 'id', class: 'text-center' },
                { data: 'branch_name', name: 'branch_name' },
                { data: 'branch_address', name: 'branch_address' },
                { data: 'branch_phone', name: 'branch_phone' },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
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
                                // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
                                $('#branchesTable td:nth-child(2), #branchesTable th:nth-child(2)').css({
                                    'max-width': '250px',
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'
                                });
                                $('#branchesTable td:nth-child(3), #branchesTable th:nth-child(3)').css({
                                    'max-width': '350px',
                                    'overflow': 'hidden',
                                    'text-overflow': 'ellipsis'
                                });
                            }
        });
    });
</script>
@endsection