@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header dan Tombol Tambah Komoditas -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('commodities.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Komoditas
            </a>
        </div>
        <!-- Section Tabel Komoditas -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Pesan Sukses (Tambah, Edit, Hapus Komoditas) -->
                        @if (session('success'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
                        <!-- Tabel Komoditas -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="commoditiesTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama Komoditas</th>
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
        $('#commoditiesTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: "{{ route('commodities.index') }}",
            autoWidth: false,
            columnDefs: [
                { width: '200px', targets: 1 } // Set lebar kolom nama komoditas
            ],
            columns: [
                { data: 'id', name: 'id', class: 'text-center' },
                { data: 'name', name: 'name', class: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
            ],
            language: {
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                search: "Cari:",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            },
            lengthMenu: [5, 10, 25, 50], // Tentukan jumlah data yang ditampilkan per halaman
            pageLength: 10,

            drawCallback: function() {                              
                $('#commoditiesTable td:nth-child(2), #commoditiesTable th:nth-child(2)').css({
                    'width': '70%', 
                   });
                $('#commoditiesTable td:nth-child(3), #commoditiesTable th:nth-child(3)').css({
                    'max-width': '30%',
                    'text-align': 'right'
                });
            }
        });
    });
</script>

<!-- Script Validasi Form -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
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
</script>

@endsection