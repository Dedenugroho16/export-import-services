@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Add Consignee</h1>
        </div>

        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Consignee Form</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('consignees.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Consignee Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="address" required>{{ old('address') }}</textarea>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tel" class="form-label">Telephone</label>
                                <input type="text" name="tel" class="form-control" id="tel" value="{{ old('tel') }}" required>
                                @error('tel')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_client" class="form-label">Client ID</label>
                                <input type="text" name="id_client" class="form-control" id="id_client" value="{{ old('id_client') }}" required>
                                @error('id_client')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn text-white" style="background-color: #182433;">Add Consignee</button>
                                <a href="{{ route('consignees.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
