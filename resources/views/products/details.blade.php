@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2>Detail Produk: {{ $product->name }}</h2>
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
                        <div class="table-responsive">
                            <table class="table card-table table-bordered table-hover table-vcenter text-nowrap">
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
                                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('detail-products.show', $detail->id) }}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                                    Show
                                                </a>
                                                <a class="dropdown-item" href="{{ route('detail-products.edit', $detail->id) }}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('detail-products.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus client ini?')" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" style=" border: none; background: none; display: block; width: 100%; text-align: left;">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    Delete
                                                    </button>
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

<!-- Form Validation Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const inputs = form.querySelectorAll('input, select, textarea');
            let isValid = true;

            inputs.forEach(input => {
                if (input.required && !input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault(); // Stop form from submitting
                alert('Silakan isi semua kolom yang wajib.');
            }
        });
    });
});
</script>

@endsection