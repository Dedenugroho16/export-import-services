@extends('layouts.layout')
@section('title', 'Detail Produk')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Dashboard Header and Add Detail Product Button -->
            <div class="mb-4 align-items-center">
                @if (in_array(auth()->user()->role, ['admin', 'operator']))
                    <a href="{{ route('detail-products.import') }}" class="btn btn-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Import Excel
                    </a>
                @endif
            </div>

            <!-- Detail Products Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <!-- Success and Error Alerts -->
                            @if (session('success') || session('failed') || session('exists'))
                                <script>
                                    let successData = @json(session('success') ?? []);
                                    let failedData = @json(session('failed') ?? []);
                                    let existsData = @json(session('exists') ?? []);

                                    let message = "";

                                    if (successData.length > 0) {
                                        message += `<strong>Detail produk berhasil diimpor:</strong><br>`;
                                        successData.forEach(detail => {
                                            message += `- ID Produk: ${detail.id_product}, Nama: ${detail.name}<br>`;
                                        });
                                        message += `<br>`;
                                    }

                                    if (existsData.length > 0) {
                                        message += `<strong>Detail produk sudah ada di database:</strong><br>`;
                                        existsData.forEach(detail => {
                                            message += `- ID Produk: ${detail.id_product}, Nama: ${detail.name}<br>`;
                                        });
                                        message += `<br>`;
                                    }

                                    if (failedData.length > 0) {
                                        message += `<strong>Detail produk gagal diimpor:</strong><br>`;
                                        failedData.forEach(detail => {
                                            message += `- ID Produk: ${detail.id_product}, Nama: ${detail.name} (Error: ${detail.error})<br>`;
                                        });
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

                            <!-- Data Table -->
                            <div class="table-responsive">
                                <table id="myTable" class="table card-table table-hover table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            @if (optional(auth()->user())->role === 'admin')
                                                <th class="text-center">ID</th>
                                            @else
                                                <th class="text-center">No</th>
                                            @endif
                                            <th class="text-center">NAMA</th>
                                            <th class="text-center">PCS</th>
                                            <th class="text-center">DIMENSI</th>
                                            <th class="text-center">TIPE</th>
                                            <th class="text-center">WARNA</th>
                                            <th class="text-center">HARGA</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#myTable').DataTable({
                serverSide: true,
                ajax: '{{ route('detail-products.index') }}',
                columns: [{
                        data: 'id',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            return row.id;
                        },
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pcs',
                        name: 'pcs',
                    },
                    {
                        data: 'dimension',
                        name: 'dimension',
                    },
                    {
                        data: 'type',
                        name: 'type',
                    },
                    {
                        data: 'color',
                        name: 'color',
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
                    // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
                    $('#myTable td:nth-child(2)').css({
                        'white-space': 'normal',
                        'word-wrap': 'break-word'
                    });

                    $('#myTable td:nth-child(4), #myTable td:nth-child(7)').css({
                        'max-width': '200px',
                        'overflow': 'hidden',
                        'text-overflow': 'ellipsis'
                    });
                }
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
    </script>

@endsection
