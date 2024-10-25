@extends('layouts.layout')
@section('title', 'Data Perusahaan')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Modal -->
        <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Tambah ukuran dialog jadi lebih besar -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="companyModalLabel">Informasi Perusahaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>     
                    <form id="companyForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="company_id" name="company_id">
        
                            <!-- Card Informasi Umum -->
                            <div class="card mb-3"> 
                                <div class="card-body">
                                    <h3>Informasi Umum</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                                <input type="text" id="company_name" name="company_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="company_code" class="form-label">Kode Perusahaan</label>
                                                <input type="text" id="company_code" name="company_code" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="registration_number" class="form-label">Nomor Registrasi</label>
                                                <input type="text" id="registration_number" name="registration_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="postal_code" class="form-label">Kode Pos</label>
                                                <input type="text" id="postal_code" name="postal_code" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="city" class="form-label">Kota</label>
                                                <input type="text" id="city" name="city" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Negara</label>
                                                <input type="text" id="country" name="country" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Alamat Lengkap</label>
                                                <textarea id="address" name="address" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="bank_account_details" class="form-label">Detail Rekening Bank</label>
                                                <textarea id="bank_account_details" name="bank_account_details" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
        
                            <!-- Card Kontak -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3>Kontak</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                                <input type="text" id="phone_number" name="phone_number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="website" class="form-label">Website</label>
                                                <input type="text" id="website" name="website" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="contact_person" class="form-label">Kontak Person</label>
                                                <input type="text" id="contact_person" name="contact_person" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Card Informasi Legal -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3>Informasi Legal & Lisensi</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="industry" class="form-label">Industri</label>
                                                <input type="text" id="industry" name="industry" class="form-control">
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tax_id" class="form-label">Nomor Pajak</label>
                                                <input type="text" id="tax_id" name="tax_id" class="form-control">
                                            </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="export_license_number" class="form-label">Nomor Lisensi Ekspor</label>
                                                    <input type="text" id="export_license_number" name="export_license_number" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="import_license_number" class="form-label">Nomor Lisensi Impor</label>
                                                    <input type="text" id="import_license_number" name="import_license_number" class="form-control">
                                                </div>
                                            </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="founded_date" class="form-label">Tanggal Didirikan</label>
                                                <input type="date" id="founded_date" name="founded_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Card Informasi Pengiriman -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h3>Informasi Pengiriman</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="payment_terms" class="form-label">Ketentuan Pembayaran</label>
                                                <input type="text" id="payment_terms" name="payment_terms" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="shipping_agent" class="form-label">Agen Pengiriman</label>
                                                <input type="text" id="shipping_agent" name="shipping_agent" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="incoterms" class="form-label">Incoterms</label>
                                                <input type="text" id="incoterms" name="incoterms" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="customs_broker" class="form-label">Brokers Bea Cukai</label>
                                                <input type="text" id="customs_broker" name="customs_broker" class="form-control">
                                            </div>
                                        </div>
					                    <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="consignee_code" class="form-label">Kode Consignee</label>
                                		        <input type="text" id="consignee_code" name="consignee_code" class="form-control">
                                            </div>
                                        </div>
					                    <div class="col-md-6">
                                            <div class="mb-3">
                                		        <label for="forwarding_agent" class="form-label">Agen Pengiriman</label>
                               			         <input type="text" id="forwarding_agent" name="forwarding_agent" class="form-control">
                            			    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                            <!-- Card Logo -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="company_logo" class="form-label">Logo Perusahaan</label>
                                        <input type="file" id="logo" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                                    </div>
                                    <div class="mb-3">
                                        <img id="logo_preview" src="{{ asset('storage/' . $company->logo ?? 'default-logo.png') }}" 
                                        alt="Logo Perusahaan" width="50px">
                                </div>
                                </div>
                            </div>  
                            <script>
                                // Fungsi untuk menampilkan pratinjau logo baru
                                function previewLogo(event) {
                                    var reader = new FileReader();
                                    reader.onload = function(){
                                        var output = document.getElementById('logo_preview');
                                        output.src = reader.result;
                                    };
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>
                        </div>
        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>             

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Informasi Perusahaan</h3>
                        <div>
                            @if ($companyExists)
                                <!-- Jika sudah ada data perusahaan, tampilkan tombol Edit -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#companyModal" onclick="openModal({{ $company->id }})">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </button>
                            @else
                                <!-- Jika belum ada data perusahaan, tampilkan tombol Tambah -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#companyModal" onclick="openModal()">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    Buat
                                </button>
                            @endif
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
                                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" style="max-width: 100px">
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

<script>
    function openModal(company_id = null) {
    if (company_id) {
        // Edit Mode: Populate the form with existing data
        fetch(`/company/${company_id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('company_id').value = data.id;
                document.getElementById('company_name').value = data.company_name;
                document.getElementById('company_code').value = data.company_code;
                document.getElementById('registration_number').value = data.registration_number;
                document.getElementById('address').value = data.address;
                document.getElementById('city').value = data.city;
                document.getElementById('country').value = data.country;
                document.getElementById('postal_code').value = data.postal_code;
                document.getElementById('phone_number').value = data.phone_number;
                document.getElementById('email').value = data.email;
                document.getElementById('website').value = data.website;
                document.getElementById('contact_person').value = data.contact_person;
                document.getElementById('industry').value = data.industry;
                document.getElementById('tax_id').value = data.tax_id;
                document.getElementById('founded_date').value = data.founded_date;
                document.getElementById('export_license_number').value = data.export_license_number;
                document.getElementById('import_license_number').value = data.import_license_number;
                document.getElementById('bank_account_details').value = data.bank_account_details;
                document.getElementById('payment_terms').value = data.payment_terms;
                document.getElementById('incoterms').value = data.incoterms;
                document.getElementById('shipping_agent').value = data.shipping_agent;
                document.getElementById('customs_broker').value = data.customs_broker;
                document.getElementById('address').value = data.address;
                document.getElementById('consignee_code').value = data.consignee_code;
                document.getElementById('forwarding_agent').value = data.forwarding_agent;
                // Populate other fields as necessary

                // Set form action to update route
                document.getElementById('companyForm').setAttribute('action', `/company/${company_id}`);
                document.getElementById('companyForm').setAttribute('method', 'POST');

                // Add hidden method for PUT request
                let methodField = document.createElement('input');
                methodField.setAttribute('type', 'hidden');
                methodField.setAttribute('name', '_method');
                methodField.setAttribute('value', 'PUT');
                document.getElementById('companyForm').appendChild(methodField);
            });
    } else {
        // Create Mode: Clear form
        document.getElementById('companyForm').reset();

        // Remove methodField for POST request
        let methodField = document.querySelector('input[name="_method"]');
        if (methodField) {
            methodField.remove();
        }

        // Set form action to store route
        document.getElementById('companyForm').setAttribute('action', `/company`);
        document.getElementById('companyForm').setAttribute('method', 'POST');
    }
}

</script>
@endsection