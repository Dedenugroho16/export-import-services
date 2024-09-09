@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Commodity Details</h1>
        </div>

        <!-- Details Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Commodity Information</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>ID:</strong> {{ $commodity->id }}</li>
                                <li><strong>Name:</strong> {{ $commodity->name }}</li>
                            </ul>
                            <a href="{{ route('commodities.edit', $commodity->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('commodities.destroy', $commodity->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this commodity?')">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('commodities.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

