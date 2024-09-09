@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Clients Details</h1>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Clients Informations</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>ID:</strong> {{ $client->id }}</li>
                                <li><strong>Name:</strong> {{ $client->name }}</li>
                                <li><strong>Address:</strong> {{ $client->address }}</li>
                                <li><strong>PO Box:</strong> {{ $client->PO_BOX }}</li>
                                <li><strong>Tel:</strong> {{ $client->tel }}</li>
                                <li><strong>Fax:</strong> {{ $client->fax }}</li>
                            </ul>
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this client?')">
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
