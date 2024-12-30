@extends('layouts.layout')
@section('title', 'Perusahaan Client')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Komoditas -->
            @if (in_array(auth()->user()->role, ['admin', 'operator']))
                <div class="mb-4 align-items-center">
                    <a href="{{ route('client-companies.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Tambah
                    </a>
                    <a href="{{ route('client-companies.import') }}" class="btn btn-warning ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Import Excel
                    </a>
                </div>
            @endif

            <!-- Section Tabel Komoditas -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <!-- Success Message for Deleting, Editing, or Adding Data -->
                            @if (session('success') || session('exists') || session('failed'))
                                <script>
                                    let successData = @json(session('success') ?? []);
                                    let existsData = @json(session('exists') ?? []);
                                    let failedData = @json(session('failed') ?? []);

                                    let message = "";

                                    if (successData.length > 0) {
                                        message += `<strong>Berhasil diimpor:</strong><br>${successData.join(', ')}<br><br>`;
                                    }

                                    if (existsData.length > 0) {
                                        message += `<strong>Sudah ada di database:</strong><br>${existsData.join(', ')}<br><br>`;
                                    }

                                    if (failedData.length > 0) {
                                        let failedDetails = failedData.map(item => `${item.company_name} - Error: ${item.error}`).join('<br>');
                                        message += `<strong>Gagal diimpor:</strong><br>${failedDetails}<br>`;
                                    }

                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Hasil Impor',
                                        html: message,
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                            @endif
                            @if (session('success_store'))
                                <script>
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: '{{ session('success_store') }}',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                            @endif
                            <!-- Tabel Komoditas -->
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap" id="clientCompanyTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Perusahaan</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">Telepon</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- Tabel Berakhir -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Script DataTables -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#clientCompanyTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('client-companies.index') }}",
                autoWidth: false,
                columnDefs: [{
                    width: '200px',
                    targets: 1
                }],
                columns: [{
                        data: null,
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'tel',
                        name: 'tel',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        class: 'text-center'
                    }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ Data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    search: "Cari :",
                    infoFiltered: "(disaring dari total _MAX_ entri)"
                },
                lengthMenu: [5, 10, 25, 50], // Tentukan jumlah data yang ditampilkan per halaman
                pageLength: 10,
                drawCallback: function() {
                    $('#clientCompanyTable td:nth-child(2), #clientCompanyTable td:nth-child(3)').css({
                        'max-width': '250px',
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });
                }
            });
        });
    </script>

    <!-- Script Validasi Form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const inputs = form.querySelectorAll('input, select, textarea');
                    let isValid = true;

                    inputs.forEach(input => {
                        if (input.required && !input.value.trim()) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault(); // Stop form from submitting
                        alert('Harap isi semua field yang dibutuhkan.');
                    }
                });
            });
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-dismissible').fadeOut();
            }, 3000);
        });
    </script>

@endsection
