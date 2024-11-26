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
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <select class="form-control" id="company_name" name="client_company" required></select>
                            </div>                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="PO_BOX" class="form-label">PO BOX</label>
                                <input type="text" id="PO_BOX" name="PO_BOX" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" required>
                            </div>
                            <div class="mb-5">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" id="fax" name="fax" class="form-control" required>
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
    // Inisialisasi Select2 untuk input company_name
$('#company_name').select2({
    ajax: {
        url: '{{ route('ajax-companies') }}',  // Menggunakan route yang sudah dibuat
        dataType: 'json',
        delay: 250,  // Mengatur delay sebelum melakukan pencarian
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
    placeholder: "Pilih Nama Perusahaan",  // Placeholder saat belum ada pilihan
    templateResult: function(company) {
        if (company.loading) return company.text;  // Tampilkan saat loading
        return $('<span>' + company.text + '</span>');  // Tampilkan nama perusahaan
    },
    templateSelection: function(company) {
        return $('<span>' + company.text + '</span>');  // Tampilkan nama perusahaan setelah dipilih
    }
});
</script>
@endsection
