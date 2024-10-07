@extends('layouts.layout')
@section('title', 'Proforma Invoice')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header dan Tombol Tambah Proforma Invoice -->
        <div class="mb-4">
            <a href="{{ route('proforma.create') }}" class="btn btn-primary">
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

        <!-- Daftar Proforma Invoice -->
        {{-- @if ($proformaInvoice->isEmpty())
            <p>Tidak ada proforma invoice yang tersedia.</p>
        @else --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Number</th>
                                    <th class="text-center">Client ID</th>
                                    <th class="text-center">Consignee ID</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($proformaInvoice as $invoice)
                                <tr>
                                    <td class="text-center">{{ $invoice->id }}</td> <!-- Menggunakan ID invoice -->
                                    <td class="text-center">{{ $invoice->code }}</td>
                                    <td class="text-center">{{ $invoice->number }}</td>
                                    <td class="text-center">{{ $invoice->id_client }}</td>
                                    <td class="text-center">{{ $invoice->id_consignee }}</td>
                                    <td class="text-center">{{ $invoice->total }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-info btn-sm">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        {{-- @endif --}}
    </div>
</div>
@endsection