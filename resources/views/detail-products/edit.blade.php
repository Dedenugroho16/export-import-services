@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Edit Detail Product</h1>
        </div>

        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Detail Product Form</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('detail-products.update', $detailProduct) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="id_product" class="form-label">Product</label>
                                <select name="id_product" id="id_product" class="form-control" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $detailProduct->id_product ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $detailProduct->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="pcs" class="form-label">PCS</label>
                                <input type="number" id="pcs" name="pcs" class="form-control" value="{{ $detailProduct->pcs }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="dimension" class="form-label">Dimension</label>
                                <input type="text" id="dimension" name="dimension" class="form-control" value="{{ $detailProduct->dimension }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" id="type" name="type" class="form-control" value="{{ $detailProduct->type }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" id="color" name="color" class="form-control" value="{{ $detailProduct->color }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ $detailProduct->price }}" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn text-white" style="background-color: #182433;">Update</button>
                                <a href="{{ route('detail-products.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
