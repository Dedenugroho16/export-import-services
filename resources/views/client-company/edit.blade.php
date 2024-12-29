@extends('layouts.layout')
@section('title', 'Client Company')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Perusahaan Klien</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Edit Form -->
                        <form action="{{ route('client-companies.update', \App\Helpers\IdHashHelper::encode($client_company->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            <div class="mb-4">
                                <label for="company_name" class="form-label">Name Perusahaan</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name', $client_company->company_name) }}" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required>{{ old('address', $client_company->address) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="PO_BOX" class="form-label">PO BOX</label>
                                <input type="text" id="PO_BOX" name="PO_BOX" class="form-control" value="{{ old('PO_BOX', $client_company->PO_BOX) }}">
                            </div>
                            <div class="mb-4">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel', $client_company->tel) }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" id="fax" name="fax" class="form-control" value="{{ old('fax', $client_company->fax) }}">
                            </div>
                            <div class="text-end">
                                <a href="{{ route('client-companies.index') }}" class="btn btn-outline-primary me-1">Kembali</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection