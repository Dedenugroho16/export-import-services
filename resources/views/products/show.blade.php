@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Product Details</h1>
        </div>

        <!-- Product Details -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Product Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> {{ $product->id }}</p>
                        <p><strong>Code:</strong> {{ $product->code }}</p>
                        <p><strong>Name:</strong> {{ $product->name }}</p>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning text-white">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white">Delete</button>
                            </form>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
