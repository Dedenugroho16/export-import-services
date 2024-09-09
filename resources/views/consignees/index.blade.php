@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <div class="mb-4  d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Consignees</h1>
            <a href="{{ route('products.create') }}" class="btn text-white" style="background-color: #182433;">
                Add Consignees
            </a>
        </div>

        <!-- Consignees Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Consignees</h3>
                    </div>

                    <div class="card-body">
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
