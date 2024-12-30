@extends('layouts.layout')
@section('title', 'Negara')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Edit Data Negara</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-important alert-success alert-dismissible" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                        </div>
                                        <div>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                </div>
                            @endif

                            <form id="countryForm"
                                action="{{ route('countries.update', \App\Helpers\IdHashHelper::encode($country->id)) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-5">
                                    <label for="name" class="form-label">Nama Negara</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $country->name) }}" required>
                                    <span class="text-danger error-message" id="error-name"></span>
                                </div>
                                <div class="mb-5">
                                    <label for="code" class="form-label">Kode Negara</label>
                                    <input type="text" id="code" name="code" class="form-control"
                                        value="{{ old('code', $country->code) }}" required>
                                    <span class="text-danger error-message" id="error-code"></span>
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('countries.index') }}" class="btn btn-outline-primary me-1">
                                        Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Perbarui
                                    </button>
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
            $('#countryForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah submit form default

                let hasError = false;

                // Bersihkan pesan error sebelumnya
                $('.error-message').text('');
                $('.form-control').removeClass('is-invalid');

                // Ambil nilai input
                const name = $('#name').val().trim();
                const code = $('#code').val().trim();

                // Validasi input
                if (name === '') {
                    $('#error-name').text('Nama negara wajib diisi.');
                    $('#name').addClass('is-invalid');
                    hasError = true;
                } else if (name.length > 255) {
                    $('#error-name').text('Nama negara tidak boleh lebih dari 255 karakter.');
                    $('#name').addClass('is-invalid');
                    hasError = true;
                }

                if (code === '') {
                    $('#error-code').text('Kode negara wajib diisi.');
                    $('#code').addClass('is-invalid');
                    hasError = true;
                } else if (code.length > 3) {
                    $('#error-code').text('Kode negara tidak boleh lebih dari 3 karakter.');
                    $('#code').addClass('is-invalid');
                    hasError = true;
                }

                // Jika tidak ada error, kirim data ke server
                if (!hasError) {
                    const formData = {
                        _token: "{{ csrf_token() }}",
                        name: name,
                        code: code
                    };

                    $.ajax({
                        url: "{{ route('countries.store') }}",
                        method: "POST",
                        data: formData,
                        success: function(data) {
                            if (data.success) {
                                // Tampilkan alert sukses menggunakan SweetAlert
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect atau reset form setelah user klik OK
                                    window.location.href =
                                        "{{ route('countries.index') }}";
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                // Tampilkan pesan error di bawah input terkait
                                if (errors.name) {
                                    $('#error-name').text(errors.name[0]);
                                    $('#name').addClass('is-invalid');
                                }
                                if (errors.code) {
                                    $('#error-code').text(errors.code[0]);
                                    $('#code').addClass('is-invalid');
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
