@extends('layouts.layout')
@section('title', 'Bill of Payments')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Header dan Tombol Tambah Proforma Invoice -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('bill-of-payment.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Buat Tagihan
                </a>
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
                                            <th class="text-center">No</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">No. INV.</th>
                                            <th class="text-center">Buyer Name</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Status</th>
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

<script>
    $(document).ready(function() {
        $('#bill-of-payments').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('bill-of-payment.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'month', name: 'month', className: 'text-center' },
                { data: 'no_inv', name: 'no_inv', className: 'text-center' },
                { data: 'client_name', name: 'client_name' },
                { data: 'company_name', name: 'company_name' },
                { data: 'status', name: 'status' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
            ],
            order: [[2, 'dsc']],
            drawCallback: function() {
                $('#bill-of-payments td:nth-child(4), #bill-of-payments td:nth-child(5), #bill-of-payments td:nth-child(6)').css({
                    'max-width': '200px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word'
                });
            }
        });
    });
</script>
@endsection
