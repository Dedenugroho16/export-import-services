@extends('layouts.layout')
@section('title', 'Daftar Invoice')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header dan Tombol Tambah Invoice -->
        <div class="mb-4">
            <a href="{{ route('transaction.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah
            </a>
        </div>

        <!-- Pesan Sukses (Jika ada) -->
        @if (session('success'))
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        <!-- Daftar Invoice -->
        @if ($transactions->isEmpty())
            <p>Tidak ada invoice yang tersedia.</p>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Number</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Client</th>
                                    <th class="text-center">Consignee</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">{{ $transaction->id }}</td>
                                        <td class="text-center">{{ $transaction->code }}</td>
                                        <td class="text-center">{{ $transaction->number }}</td>
                                        <td class="text-center">{{ $transaction->date }}</td>
                                        <td class="text-center">{{ $transaction->client->name }}</td>
                                        <td class="text-center">{{ $transaction->consignee->name }}</td>
                                        <td class="text-center">{{ $transaction->total }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('transaction.show', $transaction->id) }}">Lihat detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection