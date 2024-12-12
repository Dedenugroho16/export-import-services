@extends('layouts.layout')
@section('title', 'Import Countries')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white text-center">
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

                                <form action="{{ route('countries.import-process') }}" method="POST"
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
