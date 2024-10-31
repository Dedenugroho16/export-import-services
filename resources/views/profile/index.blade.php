@extends('layouts.layout')
@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-lg modern-card">
                <div class="card-header bg-gradient-primary text-white py-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Welcome, {{ $user->name }}!</h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square"></i> Lengkapi Profile
                    </button>
                </div>

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

                    <p class="lead text-muted mb-4">Welcome back! Here's a quick overview of your profile and account details. You can manage your settings and explore additional features below.</p>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-center mb-3 mb-md-0 profile-card">
                            <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}" alt="Profile Picture" class="img-fluid img-thumbnail rounded-circle profile-image">
                        </div>
                        <div class="col-md-8">
                            <h5 class="fw-bold">User Information</h5>
                            <ul class="list-group list-group-flush modern-list">
                                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                <li class="list-group-item"><strong>Role:</strong> {{ $user->role }}</li>
                                <li class="list-group-item"><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</li>
                                <li class="list-group-item"><strong>Signature:</strong>
                                    <img src="{{ $user->signature_url ? asset('storage/' . $user->signature_url) : 'https://via.placeholder.com/150x50' }}" alt="Signature" class="signature-image">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <div class="text-center mb-3">
                        <img id="currentProfilePicture" src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}" alt="Profile Picture" class="img-fluid img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        <p class="text-muted mt-2">Current Profile Picture</p>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_profile_picture" class="form-label">Upload Foto Profil</label>
                        <input type="file" class="form-control" id="edit_profile_picture" name="profile_picture" accept="image/*" onchange="previewProfilePicture(event)">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group mb-3">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_signature" class="form-label">Upload Signature (PNG only)</label>
                        <input type="file" class="form-control" id="edit_signature" name="signature" accept="image/png" onchange="previewSignature(event)">
                        <small class="form-text text-muted">Leave blank if you don't want to change the signature.</small>
                    </div>
                    
                    <div class="text-center mb-3">
                        <img id="currentSignature" src="{{ $user->signature_url ? asset('storage/' . $user->signature_url) : 'https://via.placeholder.com/150x50' }}" alt="Signature Image" class="img-fluid img-thumbnail signature-preview">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('editProfileModal');
        modal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('editProfileForm').reset();
            document.getElementById('currentProfilePicture').src = "{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}";
        });
    });

    function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('currentProfilePicture');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<style>
    .modern-card {
        border-radius: 20px;
        background-color: #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }

    .modern-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .profile-card {
        width: 200px;  
        height: 200px; 
        margin: 0 auto;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover; 
        border-radius: 50%; 
        border: 4px solid #007bff; 
    }

    .modern-list .list-group-item {
        background-color: #f8f9fa;
        border: none;
        font-size: 1.05rem;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 10px;
    }

    .card-header {
        background: linear-gradient(90deg, #1A5276, #21618C);
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

    .modal-lg {
        max-height: auto;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
    }

    .form-row .form-group {
        flex: 0 0 48%;
    }

    #currentProfilePicture {
        width: 80px;
        height: 80px;
    }
</style>
@endsection
