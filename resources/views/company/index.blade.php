@extends('layouts.layout')
@section('title', 'Data Perusahaan')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                Tambah Data Perusahaan
            </button>            
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0054a6;">
                        <h5 class="modal-title text-white" id="addCompanyModalLabel">Tambah Data Perusahaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Form inside Modal -->
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
                                <label for="logo" class="form-label">Logo Perusahaan</label>
                                <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                            </div>
                            
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Informasi Perusahaan</h3>
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-dots-vertical">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="#" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; display: block; width: 100%; text-align: left;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @foreach ($companies as $company)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Nama Perusahaan</th>
                                                <td>{{ $company->company_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kode Perusahaan</th>
                                                <td>{{ $company->company_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Registrasi</th>
                                                <td>{{ $company->registration_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td style="word-wrap: break-word; max-width: 300px;">{{ $company->address }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kota</th>
                                                <td>{{ $company->city }}</td>
                                            </tr>
                                            <tr>
                                                <th>Negara</th>
                                                <td>{{ $company->country }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kode Pos</th>
                                                <td>{{ $company->postal_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Telepon</th>
                                                <td>{{ $company->phone_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $company->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Website</th>
                                                <td>{{ $company->website }}</td>
                                            </tr>
                                            <tr>
                                                <th>Kontak Person</th>
                                                <td>{{ $company->contact_person }}</td>
                                            </tr>
                                            <tr>
                                                <th>Industri</th>
                                                <td>{{ $company->industry }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor NPWP</th>
                                                <td>{{ $company->tax_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Didirikan</th>
                                                <td>{{ $company->founded_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Lisensi Ekspor</th>
                                                <td>{{ $company->export_license_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nomor Lisensi Impor</th>
                                                <td>{{ $company->import_license_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Detail Rekening Bank</th>
                                                <td>{{ $company->bank_account_details }}</td>
                                            </tr>
                                            <tr>
                                                <th>Syarat Pembayaran</th>
                                                <td>{{ $company->payment_terms }}</td>
                                            </tr>
                                            <tr>
                                                <th>Incoterms</th>
                                                <td>{{ $company->incoterms }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Agent</th>
                                                <td>{{ $company->shipping_agent }}</td>
                                            </tr>
                                            <tr>
                                                <th>Customs Broker</th>
                                                <td>{{ $company->customs_broker }}</td>
                                            </tr>
                                            <tr>
                                                <th>Consignee Code</th>
                                                <td>{{ $company->consignee_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>Forwarding Agent</th>
                                                <td>{{ $company->forwarding_agent }}</td>
                                            </tr>
                                            <tr>
                                                <th>Logo</th>
                                                <td>
                                                    @if($company->logo)
                                                        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->company_name }} Logo" style="max-width: 100px;">
                                                    @else
                                                        <span>No logo uploaded</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection