@extends('layouts.layout')

@section('title', 'Data User') <!-- Judul halaman -->

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="bg-white p-4 rounded shadow-sm"> <!-- Tambahkan wrapper dengan background putih -->
            <table class="table table-bordered table-striped" id="usersTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diisi oleh DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script untuk DataTables -->
<script type="text/javascript">
        $(document).ready(function() {
            $('#usersTable').DataTable({
                processing: false, // Menonaktifkan tampilan loading
                serverSide: true,
                ajax: "{{ route('users.index') }}", // Sesuaikan dengan route yang sesuai
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' }
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
                lengthMenu: [5, 10, 25, 50], // Tentukan jumlah data yang ditampilkan per halaman
                pageLength: 10
            });
        });
    </script>
@endsection
