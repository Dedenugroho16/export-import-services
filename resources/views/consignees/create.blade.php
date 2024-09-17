@extends('layouts.layout')

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

                            <!-- Client Dropdown -->
                            <div class="mb-5">
                                <label for="id_client" class="form-label">Client</label>
                                <select id="id_client" name="id_client" class="form-control" required>
                                    <option value="">Pilih Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('id_client') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_client')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="text-end">
                                <a href="{{ route('consignees.index') }}" class="btn btn-outline-primary">Kembali</a>
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
