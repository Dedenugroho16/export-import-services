@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Card Details Product -->
        <div class="card mb-5">
            <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Informasi Produk</h3>
                <div class="dropdown">
                    <a class="btn btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('products.edit', \App\Helpers\IdHashHelper::encode($product->id)) }}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', \App\Helpers\IdHashHelper::encode($product->id)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger" style=" border: none; background: none; display: block; width: 100%; text-align: left;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                            Delete
                            </button>
                        </form>
                    </ul>
                </div>
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
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('detail-products.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            Kembali
                        </a>
                    </div>
                    
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