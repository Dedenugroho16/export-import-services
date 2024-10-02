@extends('layouts.layout')

@section('title', 'Edit Data Cabang')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Data Cabang</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Edit Form -->
                        <form action="{{ route('branches.update', \App\Helpers\IdHashHelper::encode($branch->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="branch_name" class="form-label">Nama Cabang</label>
                                <input type="text" id="branch_name" name="branch_name" class="form-control" value="{{ old('branch_name', $branch->branch_name) }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="branch_address" class="form-label">Alamat Cabang</label>
                                <input type="text" id="branch_address" name="branch_address" class="form-control" value="{{ old('branch_address', $branch->branch_address) }}" required>
                            </div>
                            <div class="mb-4">
                                <label for="branch_phone" class="form-label">Telepon Cabang</label>
                                <input type="text" id="branch_phone" name="branch_phone" class="form-control" value="{{ old('branch_phone', $branch->branch_phone) }}" required>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('branches.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection