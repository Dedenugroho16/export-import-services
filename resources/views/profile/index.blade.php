@extends('layouts.layout')
@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-lg modern-card">
                <!-- Header card -->
                <div class="card-header bg-gradient-primary text-white py-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Welcome, {{ $user->name }}!</h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </button>
                </div>

                <!-- Body card -->
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Welcome text -->
                    <p class="lead text-muted mb-4">Welcome back! Here's a quick overview of your profile and account details. You can manage your settings and explore additional features below.</p>

                    <!-- User Information -->
                    <div class="row align-items-center mb-4">
                        <!-- Profile Picture -->
                        <div class="col-md-4 text-center mb-3 mb-md-0 profile-card">
                            <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}" alt="Profile Picture" class="img-fluid img-thumbnail rounded-circle profile-image">
                        </div>
                        <!-- User Details -->
                        <div class="col-md-8">
                            <h5 class="fw-bold">User Information</h5>
                            <ul class="list-group list-group-flush modern-list">
                                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                <li class="list-group-item"><strong>Role:</strong> {{ $user->role }}</li>
                                <li class="list-group-item"><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_profile_picture" class="form-label">Upload Foto Profil</label>
                        <input type="file" class="form-control" id="edit_profile_picture" name="profile_picture">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to reset form -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('editProfileModal');
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('editProfileForm').reset();
        });
    });
</script>

<!-- CSS for improved appearance -->
<style>
    /* Modern card style */
    .modern-card {
        border-radius: 20px;
        background-color: #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .modern-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Ukuran lebih besar untuk card gambar profil */
    .profile-card {
        width: 200px;  
        height: 200px; 
        margin: 0 auto;
    }

    /* Ukuran lebih besar untuk gambar profil */
    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover; 
        border-radius: 50%; 
        border: 4px solid #007bff; 
    }

    /* Modern list style */
    .modern-list .list-group-item {
        background-color: #f8f9fa;
        border: none;
        font-size: 1.05rem;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 10px;
    }

    /* Header styling */
    .card-header {
        background: linear-gradient(90deg, #1A5276, #21618C); /* Gradasi biru nefi */
        color: white;
        border-radius: 20px 20px 0 0;
    }

    .list-group-item strong {
        color: #495057;
    }

    .btn-outline-primary, .btn-outline-secondary {
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-outline-primary:hover, .btn-outline-secondary:hover {
        background-color: #007bff;
        color: white;
    }

    .modal-content {
        border-radius: 20px;
    }

    .lead {
        font-size: 1.1rem;
    }

    .alert {
        border-radius: 10px;
    }
</style>
@endsection
