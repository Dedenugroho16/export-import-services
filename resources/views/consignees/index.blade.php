@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Consignees</h1>
            <a href="{{ route('consignees.create') }}" class="btn text-white" style="background-color: #182433;">
                Add Consignee
            </a>
        </div>

        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Consignees</h3>
                    </div>

                    <div class="card-body">
                        <!-- Success Message for Deleting, Editing, or Adding Client -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Table starts here -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Tel</th>
                                        <th>ID Client</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($consignees as $consignee)
                                    <tr>
                                        <td>{{ $consignee->id }}</td>
                                        <td>{{ $consignee->name }}</td>
                                        <td>{{ $consignee->address }}</td>
                                        <td>{{ $consignee->tel }}</td>
                                        <td>{{ $consignee->id_client }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Consignees found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
