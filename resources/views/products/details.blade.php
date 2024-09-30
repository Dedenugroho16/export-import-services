@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 mt-4">
            <a href="{{ route('detail-products.create') }}" class="btn btn-primary">
                Tambah
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                Kembali
            </a>
        </div>
        <div class="card mb-5">
            <div class="card-header shadow-sm p-3">
                <h3 class="card-title">Informasi Produk</h3>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <th>Kode Produk</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Nama Produk</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                        </tbody>
                    </table>                   
                    
                </div>
            </div>
        </div>
        <!-- Product Details Table -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('details_success'))
                            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </div>
                                    <div>
                                        {{ session('details_success') }}
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        <!-- DataTables Integration -->
                        <div class="table-responsive">
                            <table id="detailProductTable" class="table card-table table-bordered table-hover table-vcenter text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Pcs</th>
                                        <th class="text-center">Dimensi</th>
                                        <th class="text-center">Tipe</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Harga</th>
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

<!-- DataTables Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#detailProductTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('products.details', $hash) }}",
                type: 'GET'
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'pcs', name: 'pcs', className: 'text-center' },
                { data: 'dimension', name: 'dimension', className: 'text-center' },
                { data: 'type', name: 'type', className: 'text-center' },
                { data: 'color', name: 'color', className: 'text-center' },
                { data: 'price', name: 'price', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
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
            pageLength: 10
        });
    });
</script>


@endsection