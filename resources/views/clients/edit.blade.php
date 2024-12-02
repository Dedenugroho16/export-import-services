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
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="client_company_id" class="form-label">Nama Perusahaan</label>
                                <select class="form-control" id="client_company_id" name="client_company_id" required>
                                    @if($client->company)
                                        <option value="{{ $client->company->id }}" selected>{{ $client->company->company_name }}</option>
                                    @endif
                                </select>
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
                                <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="window.history.back();">Kembali</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Select2 untuk input company_name
    $('#client_company_id').select2({
        ajax: {
            url: '{{ route('ajax-companies') }}',  // Endpoint AJAX untuk mengambil data perusahaan
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term  // Mengirimkan kata kunci pencarian ke server
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(company) {
                        return {
                            id: company.id,  // Menyimpan ID perusahaan
                            text: company.company_name  // Menampilkan nama perusahaan
                        };
                    })
                };
            },
            cache: true
        },
        placeholder: "Pilih Nama Perusahaan",
        templateResult: function(company) {
            if (company.loading) return company.text;
            return $('<span>' + company.text + '</span>');
        },
        templateSelection: function(company) {
            return $('<span>' + company.text + '</span>');
        }
    });
</script>
@endsection
