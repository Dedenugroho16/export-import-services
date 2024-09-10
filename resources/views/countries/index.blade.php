@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header -->
        <!-- Dashboard Header and Add Detail Product Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Countries</h1>
            <a href="{{ route('countries.create') }}" class="btn text-white" style="background-color: #182433;">
                Add Country
            </a>            
        </div>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Countries Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Countries</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $country)
                                    <tr>
                                        <td>{{ $country->name }}</td>
                                        <td class="text-center">{{ $country->code }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
