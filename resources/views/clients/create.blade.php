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
                        <h3 class="card-title">Tambah Data Client</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="client_companies" class="form-label">Perusahaan Client</label>
                                <select id="client_companies" name="client_companies[]" class="form-control" multiple required>
                                </select>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi Select2 untuk input client_companies
    $('#client_companies').select2({
        ajax: {
            url: '{{ route('ajax-companies') }}', // Route untuk mengambil data perusahaan
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term // Kata kunci pencarian
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(company) {
                        return {
                            id: company.id,
                            text: company.company_name
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