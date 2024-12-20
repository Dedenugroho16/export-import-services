@extends('layouts.layout')
@section('title', 'Client Company')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Success Message for Deleting, Editing, or Adding Data -->
        @if (session('success'))
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Informasi Perusahaan Client</h3>
                        @if(in_array(auth()->user()->role, ['admin', 'operator']))
                            <a class="btn btn-light" href="{{ url('/client-companies/' . App\Helpers\IdHashHelper::encode($client_company->id) . '/edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Edit
                            </a>    
                        @endif
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $client_company->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <td>{{ $client_company->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td style="word-wrap: break-word; max-width: 300px;">{{ $client_company->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>PO Box</th>
                                        <td>{{ $client_company->PO_BOX }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ $client_company->tel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fax</th>
                                        <td>{{ $client_company->fax }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-5 d-flex justify-content-end">
                                <a href="{{ route('client-companies.index') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert-dismissible').fadeOut();
        }, 3000);
    });
</script>
@endsection