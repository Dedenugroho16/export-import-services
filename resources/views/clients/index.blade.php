@extends('layouts.layout')
@section('title', 'Client')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Dashboard Header and Add Client Button -->
            @if (in_array(auth()->user()->role, ['admin', 'operator']))
                <div class="mb-4 align-items-center">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah
                    </a>
                    <a href="{{ route('clients.import') }}" class="btn btn-warning ms-3">
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
            <!-- Clients Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <!-- Success Message for Deleting, Editing, or Adding Data -->
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: '{{ session('success') }}',
                                        confirmButtonText: 'OK'
                                    });
                                </script>
                            @endif
                            <!-- Table Starts Here -->
                            <div class="table-responsive">
                                <table class="table card-table table-hover table-vcenter text-nowrap" id="clientTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Client</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- Table ends here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#clientTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('clients.index') }}",
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
                        data: 'name',
                        name: 'name'
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
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
            });
        });
    </script>

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
                        alert('Please fill in all required fields.');
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
