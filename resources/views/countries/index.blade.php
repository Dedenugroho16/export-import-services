@extends('layouts.layout')
@section('title', 'Negara')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Komoditas -->
            @if (in_array(auth()->user()->role, ['admin', 'operator']))
                <div class="mb-4 d-flex align-items-center">
                    <a href="{{ route('countries.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Tambah
                    </a>
                    <a href="{{ route('countries.import') }}" class="btn btn-warning ms-3">
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
            <!-- Countries Section -->
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
                                <table id="countryTable" class="table card-table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Negara</th>
                                            <th class="text-center">Kode Negara</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data loaded via DataTables -->
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
            $('#countryTable').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('countries.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name',
                        class: 'text-center'
                    },
                    {
                        data: 'code',
                        name: 'code',
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
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,

                drawCallback: function() {
                    $('#countryTable td:nth-child(1), #countryTable th:nth-child(1), #countryTable td:nth-child(2), #countryTable th:nth-child(2)')
                        .css({
                            'width': '50%',
                        });
                    $('#countryTable td:nth-child(3), #countryTable th:nth-child(3)').css({
                        'width': '5%',
                    });

                }
            });
        });

        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-dismissible').fadeOut();
            }, 3000);
        });
    </script>
@endsection
