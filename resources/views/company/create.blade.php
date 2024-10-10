@extends('layouts.layout')
@section('title', 'Data Perusahaan')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Tambah Data Perusahaan</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <input type="text" id="company_name" name="company_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="company_code" class="form-label">Kode Perusahaan</label>
                                <input type="text" id="company_code" name="company_code" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="registration_number" class="form-label">Nomor Registrasi</label>
                                <input type="text" id="registration_number" name="registration_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">Kota</label>
                                <input type="text" id="city" name="city" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Negara</label>
                                <input type="text" id="country" name="country" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" id="website" name="website" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="contact_person" class="form-label">Kontak Person</label>
                                <input type="text" id="contact_person" name="contact_person" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="industry" class="form-label">Industri</label>
                                <input type="text" id="industry" name="industry" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="tax_id" class="form-label">Nomor Pajak</label>
                                <input type="text" id="tax_id" name="tax_id" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="founded_date" class="form-label">Tanggal Didirikan</label>
                                <input type="date" id="founded_date" name="founded_date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="export_license_number" class="form-label">Nomor Lisensi Ekspor</label>
                                <input type="text" id="export_license_number" name="export_license_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="import_license_number" class="form-label">Nomor Lisensi Impor</label>
                                <input type="text" id="import_license_number" name="import_license_number" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="bank_account_details" class="form-label">Detail Rekening Bank</label>
                                <textarea id="bank_account_details" name="bank_account_details" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="payment_terms" class="form-label">Ketentuan Pembayaran</label>
                                <input type="text" id="payment_terms" name="payment_terms" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="incoterms" class="form-label">Incoterms</label>
                                <input type="text" id="incoterms" name="incoterms" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="shipping_agent" class="form-label">Agen Pengiriman</label>
                                <input type="text" id="shipping_agent" name="shipping_agent" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="customs_broker" class="form-label">Brokers Bea Cukai</label>
                                <input type="text" id="customs_broker" name="customs_broker" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="consignee_code" class="form-label">Kode Consignee</label>
                                <input type="text" id="consignee_code" name="consignee_code" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="forwarding_agent" class="form-label">Agen Pengiriman</label>
                                <input type="text" id="forwarding_agent" name="forwarding_agent" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Perusahaan (opsional)</label>
                                <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                            </div>

                            <div class="text-end">
                                <a href="{{ route('company.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection