@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header and Add Detail Product Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('detail-products.create') }}" class="btn text-white" style="background-color: #182433;">
                Add Detail Product
            </a>
        </div>
        <!-- Detail Products Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Detail Products</h3>
                    </div>
                    <div class="card-body">
                    @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID Product</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Pcs</th>
                                        <th class="text-center">Dimension</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Color</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailProducts as $detailProduct)
                                    <tr>
                                        <td class="text-center">{{ $detailProduct->id_product }}</td>
                                        <td class="text-center">{{ $detailProduct->name }}</td>
                                        <td class="text-center">{{ $detailProduct->pcs }}</td>
                                        <td class="text-center">{{ $detailProduct->dimension }}</td>
                                        <td class="text-center">{{ $detailProduct->type }}</td>
                                        <td class="text-center">{{ $detailProduct->color }}</td>
                                        <td class="text-center">{{ $detailProduct->price }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('detail-products.show', $detailProduct->id) }}" class="btn btn-info btn-sm text-white" title="Show">
                                                Show
                                            </a>
                                            <a href="{{ route('detail-products.edit', $detailProduct->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                Edit
                                            </a>
                                            <form action="{{ route('detail-products.destroy', $detailProduct->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this detail product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white" title="Delete">
                                                    Delete
                                                </button>
                                            </form>
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
                alert('Please fill in all required fields.');
            }
        });
    });
});
</script>

@endsection
