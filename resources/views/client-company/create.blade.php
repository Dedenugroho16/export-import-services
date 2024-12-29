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
                        <h3 class="card-title">Tambah Data Perusahaan Klien</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </div>
                                    <div>
                                        {{ session('success') }}
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        <form action="{{ route('client-companies.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="PO_BOX" class="form-label">PO BOX</label>
                                <input type="text" id="PO_BOX" name="PO_BOX" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" required>
                            </div>
                            <div class="mb-6">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" id="fax" name="fax" class="form-control" required>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('client-companies.index') }}" class="btn btn-outline-primary me-1">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection