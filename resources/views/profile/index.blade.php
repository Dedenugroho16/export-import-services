@extends('layouts.layout')
@section('title', 'Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <!-- Header card -->
                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Welcome, {{ Auth::user()->name }}!</h4>
                    <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person"></i> View Profile
                    </a>
                </div>

                <!-- Body card -->
                <div class="card-body">
                    <!-- Welcome text -->
                    <p class="lead text-muted mb-4">Welcome back! Here's a quick overview of your profile and account details. You can manage your settings and explore additional features below.</p>

                    <!-- User Information -->
                    <div class="row align-items-center mb-4">
                        <!-- Profile Picture -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ Auth::user()->profile_picture_url ?? 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="img-thumbnail rounded-circle" width="150">
                        </div>
                        <!-- User Details -->
                        <div class="col-md-8">
                            <h5 class="fw-bold">User Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ Auth::user()->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                                <li class="list-group-item"><strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Actions buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="" class="btn btn-outline-primary me-md-2">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                        <a href="" class="btn btn-outline-secondary">
                            <i class="bi bi-pencil-square"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
