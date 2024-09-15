@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header Section -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Client Details</h1>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Client Information</h3>
                    </div>

                    <!-- Table Section for Client Details -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">ID</th>
                                        <td>{{ $client->id }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{ $client->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td>{{ $client->address }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">PO Box</th>
                                        <td>{{ $client->PO_BOX }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tel</th>
                                        <td>{{ $client->tel }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fax</th>
                                        <td>{{ $client->fax }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning text-white">Edit</a>

                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white" onclick="return confirm('Are you sure you want to delete this client?')">
                                    Delete
                                </button>
                            </form>

                            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
