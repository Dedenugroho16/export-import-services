@extends('layouts.layout')
@section('title', 'Consignee')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Tambah Data Consignee</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <!-- Consignee Form -->
                        <form action="{{ route('consignees.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            
                            <!-- Hidden field for product ID -->
                            <input type="hidden" name="id_client" value="{{ $client->id }}">

                            <!-- Consignee Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Consignee</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required>{{ old('address') }}</textarea>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telephone -->
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel') }}" required>
                                @error('tel')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <!-- Buttons -->
                            <div class="text-end">
                                <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="window.history.back();">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                        <!-- End of Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
