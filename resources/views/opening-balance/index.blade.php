@extends('layouts.layout')
@section('title', 'Opening Balance')

@section('content')
<div class="page-body">
        <div class="container-xl">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('opening-balance.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Tambah
                </a>
            </div>
                    <div class="card">
                        <div class="card-body">
                            <h3>Daftar Balance</h3>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection