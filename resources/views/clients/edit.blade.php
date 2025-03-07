@extends('layouts.layout')
@section('title', 'Client')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
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
                            <div class="mb-4">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                            </div>
                            <div class="mb-6">
                                <label for="client_companies" class="form-label">Perusahaan Client</label>
                                <select id="client_companies" name="client_companies[]" class="form-control" multiple required>
                                    <!-- Old Values akan di-append melalui JavaScript -->
                                </select>
                            </div>
                            <div class="text-end">
                                <a href="javascript:void(0);" class="btn btn-outline-primary me-1" onclick="window.history.back();">Kembali</a>
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
    $(document).ready(function() {
        // Ambil data perusahaan lama (selected)
        let selectedCompanies = @json($selectedCompanies);

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

        // Tambahkan data perusahaan lama ke Select2
        selectedCompanies.forEach(function(company) {
            let option = new Option(company.text, company.id, true, true);
            $('#client_companies').append(option).trigger('change');
        });
    });
</script>
@endsection