@extends('layouts.layout')
@section('title', 'Client')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Data Client</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Edit Form -->
                        <form action="{{ route('clients.update', \App\Helpers\IdHashHelper::encode($client->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required>{{ old('address', $client->address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="PO_BOX" class="form-label">PO BOX</label>
                                <input type="text" id="PO_BOX" name="PO_BOX" class="form-control" value="{{ old('PO_BOX', $client->PO_BOX) }}">
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel', $client->tel) }}" required>
                            </div>
                            <div class="mb-5">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" id="fax" name="fax" class="form-control" value="{{ old('fax', $client->fax) }}">
                            </div>
                            <div class="text-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">Kembali</a>
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
