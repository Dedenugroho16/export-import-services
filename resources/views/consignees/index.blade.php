@extends('layouts.layout')
@section('title', 'Consignee')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header dan Tombol Tambah Consignee -->
        
        <!-- Section Tabel Consignee -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Pesan Sukses (Tambah, Edit, Hapus Consignee) -->
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
                        <!-- Tabel Consignee -->
                        <div class="table-responsive">
                            <table id="consigneeTable" class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">ID Client</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi oleh DataTables -->
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
        $('#consigneeTable').DataTable({
            processing: false,
            serverSide: true, 
            ajax: "{{ route('consignees.index') }}", // URL untuk AJAX
            columns: [
                { data: 'id', name: 'id', class: 'text-center' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address', class: 'text-center' },
                { data: 'tel', name: 'tel', class: 'text-center' },
                { data: 'id_client', name: 'id_client', class: 'text-center' },
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
                search: "Cari :",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            },
            lengthMenu: [5, 10, 25, 50], // Opsi jumlah entri per halaman
            pageLength: 10,

            drawCallback: function() {
                // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
                $('#consigneeTable td:nth-child(2), #consigneeTable th:nth-child(2)').css({
                    'max-width': '200px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word'
                });
                $('#consigneeTable td:nth-child(3), #consigneeTable th:nth-child(3)').css({
                    'max-width': '250px',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis'
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
                alert('Harap isi semua field yang diperlukan.');
            }
        });
    });
});
</script>

@endsection
