@extends('layouts.layout') 
@section('title', 'Profile') 

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded-lg modern-card">
                <div class="card-header text-white" style="background-color: #007bff;">
                    <a href="{{ route('home') }}" class="text-secondary">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="white"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                    </a> 
                    <h2 class="mb-0">User Information</h2>
                </div>
                <div class="card-body">
                    <!-- Alert Section -->
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Profile Section -->
                    <div class="container">
                        <div class="row align-items-center mb-5">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center profile-card">
                                <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}" 
                                    alt="Profile Picture" 
                                    class="img-fluid rounded-circle profile-image shadow-lg mb-4">
                            </div>

                            <!-- User Information -->
                            <div class="col-md-8">
                                <div class="user-info-card shadow p-4 bg-white rounded">
                                    <h3 class="fw-bold text-primary mb-4">Welcome, {{ $user->name }}!</h3>
                                    <table class="table table-hover table-borderless">
                                        <tr>
                                            <th class="text-secondary">Username</th>
                                            <td>:</td>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary">Nama</th>
                                            <td>:</td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary">Role</th>
                                            <td>:</td>
                                            <td class="text-capitalize">{{ $user->role }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary">Bergabung Pada</th>
                                            <td>:</td>
                                            <td class="text-capitalize">{{ $user->created_at->format('d F, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary">Tanda Tangan</th>
                                            <td>:</td>
                                            <td>
                                                <img src="{{ $user->signature_url ? asset('storage/' . $user->signature_url) : 'https://via.placeholder.com/200x100' }}" 
                                                    alt="Signature" 
                                                    class="img-fluid signature-image shadow-sm" style="width: 200px">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                Edit Profile
                                           </button></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons Section -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="currentProfilePicture" src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : 'https://via.placeholder.com/200' }}" 
                             class="img-fluid rounded-circle shadow profile-image-preview" style="width: 120px; height: 120px;">
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Upload Profile Picture</label>
                        <input type="file" class="form-control" name="profile_picture" accept="image/*" onchange="previewProfilePicture(event)">
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Upload Signature (PNG only)</label>
                        <input type="file" class="form-control" name="signature" accept="image/png" onchange="previewSignature(event)">
                    </div>
                    <div class="mb-5">
                        <img id="currentSignature" src="{{ $user->signature_url ? asset('storage/' . $user->signature_url) : 'https://via.placeholder.com/200x100' }}" 
                             class="img-fluid signature-image-preview" style="width: 200px">
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
function previewProfilePicture(event) {
    const reader = new FileReader();
    reader.onload = () => document.getElementById('currentProfilePicture').src = reader.result;
    reader.readAsDataURL(event.target.files[0]);
}

function previewSignature(event) {
    const reader = new FileReader();
    reader.onload = () => document.getElementById('currentSignature').src = reader.result;
    reader.readAsDataURL(event.target.files[0]);
}

$(document).ready(function() {
        setTimeout(function() {
            $('.alert-dismissible').fadeOut();
        }, 3000);
    });
</script>

<style>
.modern-card {
    border-radius: 15px;
    background-color: #f8f9fa;
}

.profile-card {
    width: 200px;
    margin: auto;
}

.signature-image {
    max-width: 200px;
    height: auto;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    padding: 5px;
}
.profile-image {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border: 5px solid #f0f0f5;
}

.user-info-card {
    transition: all 0.3s ease;
}

.user-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.table th {
    width: 150px;
    font-weight: bold;
}

.signature-image {
    width: 100%;
    max-width: 250px;
    object-fit: contain;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 5px;
}

</style>
@endsection