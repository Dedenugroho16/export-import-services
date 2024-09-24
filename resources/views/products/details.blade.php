@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2>Detail produk : {{ $product->name }}</h2>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12h14M5 12l6 6M5 12l6-6"/>
                </svg>
                Kembali
            </a>
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
                                <tbody>
                                    @foreach($product->detailProducts as $detail)
                                    <tr>
                                        <td>{{ $detail->name }}</td>
                                        <td class="text-center">{{ $detail->pcs }}</td>
                                        <td class="text-center">{{ $detail->dimension }}</td>
                                        <td class="text-center">{{ $detail->type }}</td>
                                        <td class="text-center">{{ $detail->color }}</td>
                                        <td class="text-center">{{ $detail->price }}</td>
                                        <td class="text-center">
                                            <!-- Aksi buttons as dropdown -->
                                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('detail-products.show', \App\Helpers\IdHashHelper::encode($detail->id)) }}">Show</a>
                                                <a class="dropdown-item" href="{{ route('detail-products.edit', \App\Helpers\IdHashHelper::encode($detail->id)) }}">Edit</a>
                                                <form action="{{ route('detail-products.destroy', \App\Helpers\IdHashHelper::encode($detail->id)) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus detail produk ini?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
            serverSide: false, // Disable server-side processing as we are passing the data directly via Blade
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                search: "Cari:",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            drawCallback: function() {
                // Terapkan style khusus untuk kolom-kolom tertentu seperti pada tabel clients
                $('#detailProductTable td:nth-child(1), #detailProductTable th:nth-child(1)').css({
                    'max-width': '200px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word'
                });
                $('#detailProductTable td:nth-child(3), #detailProductTable th:nth-child(3)').css({
                    'max-width': '250px',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis'
                });
            }
        });
    });
</script>

@endsection
