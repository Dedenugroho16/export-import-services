@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3">
                        <h3 class="card-title">Informasi Client</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $client->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Client</th>
                                        <td>{{ $client->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td style="word-wrap: break-word; max-width: 300px;">{{ $client->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>PO Box</th>
                                        <td>{{ $client->PO_BOX }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ $client->tel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fax</th>
                                        <td>{{ $client->fax }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
