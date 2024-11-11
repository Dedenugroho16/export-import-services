@extends('layouts.layout')
@section('title', 'Bill of Payments')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Proforma Invoice -->
            <div class="mb-4">
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#waitingBill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                        <path
                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                    </svg>
                    Menunggu Persetujuan
                </button>
            </div>

            <div class="container-xl">
                <!-- Pesan Sukses (Jika ada) -->
                @if (session('success'))
                    <div class="alert alert-important alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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
                    <p>Tidak ada bill of payment yang tersedia.</p>
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
    </div>

    <div class="modal fade text-left" id="waitingBill" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Menunggu Persetujuan</h4>
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
                        <a href="{{ route('bill-of-payment.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Buat
                        </a>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-2 mt-1">Daftar Proforma</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="waitingBillTable">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script></script>
@endsection
