@extends('layouts.layout')
@section('title', 'Bill of Payments')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Pesan Sukses (Jika ada) -->
            @if (session('success'))
                <div class="alert alert-important alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
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
                        <h3>Daftar Tagihan Pembayaran</h3>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="bill-of-payments">
                                <thead>
                                    <tr>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">No. INV.</th>
                                        <th class="text-center">Buyer Name</th>
                                        <th class="text-center">Company Name</th>
                                        <th class="text-center">PI. Number</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        
    </script>
@endsection
