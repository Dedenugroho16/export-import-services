@extends('layouts.layout')

@section('title', 'Data User')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Tambah User
            </a>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Toast notifications -->
                        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
                            <div id="addToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        User berhasil ditambahkan!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                            <div id="editToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        User berhasil diubah!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                            <div id="deleteToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        User berhasil dihapus!
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Add User Modal -->
                        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="addUserForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Tambah User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="editUserForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="edit_name" name="name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="edit_email" name="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="edit_password" name="password">
                                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit_password_confirmation" class="form-label">Konfirmasi Password</label>
                                                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                                            </div>
                                            <input type="hidden" id="edit_user_id" name="user_id">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Update User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Created At</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data diisi oleh DataTables -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#usersTable').DataTable({
            processing: true, 
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'password', name: 'password' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
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
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            bAutoWidth: false,
            bLengthChange: true,
            processing: false,
            searching: true,
        });

        // Reset form when Add User modal is shown
        $('#addUserModal').on('shown.bs.modal', function () {
            $('#addUserForm')[0].reset();
        });

        // Handle Add User form submission
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('users.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    table.ajax.reload();
                    var addToast = new bootstrap.Toast(document.getElementById('addToast'));
                    addToast.show();
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan: ' + (xhr.responseJSON?.message || xhr.responseText);
                    alert(errorMessage);
                }
            });
        });

        // Handle Edit User button click
        $('#usersTable').on('click', '.edit-user', function() {
            var userId = $(this).data('id');
            $.ajax({
                url: "/users/" + userId + "/edit",
                method: 'GET',
                success: function(data) {
                    $('#edit_name').val(data.name);
                    $('#edit_email').val(data.email);
                    $('#edit_user_id').val(data.id);
                    $('#editUserModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error fetching user data: ' + xhr.responseText);
                }
            });
        });

        // Handle Edit User form submission
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            var userId = $('#edit_user_id').val();
            $.ajax({
                url: "/users/" + userId,
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editUserModal').modal('hide');
                    table.ajax.reload();
                    var editToast = new bootstrap.Toast(document.getElementById('editToast'));
                    editToast.show();
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan: ' + (xhr.responseJSON?.message || xhr.responseText);
                    alert(errorMessage);
                }
            });
        });

        // Handle Delete User
        $('#usersTable').on('click', '.delete-user', function() {
            var userId = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                $.ajax({
                    url: "/users/" + userId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        table.ajax.reload();
                        var deleteToast = new bootstrap.Toast(document.getElementById('deleteToast'));
                        deleteToast.show();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus pengguna: ' + xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection
