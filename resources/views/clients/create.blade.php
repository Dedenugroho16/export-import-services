@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Add New Clients</h1>
        </div>

        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Clients Form</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('clients.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="PO_BOX" class="form-label">PO Box</label>
                                <input type="text" id="PO_BOX" name="PO_BOX" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telephone</label>
                                <input type="text" id="tel" name="tel" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="fax" class="form-label">Fax</label>
                                <input type="text" id="fax" name="fax" class="form-control">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn text-white" style="background-color: #182433;">Create</button>
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
