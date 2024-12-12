@extends('layouts.layout')
@section('title', 'Import Products')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white text-center">
                                <a href="{{ route('products.index') }}" class="text-secondary" title="Kembali">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="white"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                                </a>
                                <h4 class="mb-0">Import Data Excel</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: '{{ $errors->first() }}',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif

                                @if (session('error'))
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: '{{ session('error') }}',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif
                                <form action="{{ route('products.import-process') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="excelFile" class="form-label">Pilih File Excel</label>
                                        <input type="file" class="form-control" id="excelFile" name="file"
                                            accept=".xls,.xlsx" required aria-describedby="fileHelp">
                                        <div id="fileHelp" class="form-text text-muted">
                                            Format yang didukung: .xls, .xlsx.
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-upload me-2"></i> Import
                                    </button>
                                </form>
                            </div>
                            <div class="card-footer text-center text-muted">
                                Pastikan file sesuai format template untuk menghindari error.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
