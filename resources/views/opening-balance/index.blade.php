@extends('layouts.layout')
@section('title', 'Opening Balance')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 d-flex justify-content-between align-items-center">
        @if(in_array(auth()->user()->role, ['admin', 'finance']))
            <a href="{{ route('opening-balance.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icon-tabler-plus">
                    <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Tambah
            </a>
        @endif
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                    </div>
                @endif
                <h3>Daftar Balance</h3>
                <div class="table-responsive">
                    <table id="openingBalanceTable" class="table card-table table-hover table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nomor Pembayaran</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Client Name</th>
                                <th class="text-center">Client Company Name</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script DataTables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#openingBalanceTable').DataTable({
            processing: true, // Menampilkan loading saat data diproses
            serverSide: true, // Menyatakan DataTables akan menggunakan server side processing
            ajax: "{{ route('opening-balance.index') }}", // URL untuk request data
            columns: [
                { 
                    data: null,  // Kolom nomor urut, dihitung di frontend
                    class: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Nomor urut berdasarkan posisi data
                    },
                    orderable: false, // Kolom ini tidak dapat diurutkan
                    searchable: false // Kolom ini tidak dapat dicari
                },
                { data: 'payment_number', name: 'payment_number', class: 'text-center' },
                { data: 'date', name: 'date', class: 'text-center' },
                { data: 'client_name', name: 'client_name', class: 'text-center' },
                { data: 'client_company_name', name: 'client_company_name', class: 'text-center' },
                { 
                    data: 'total', 
                    name: 'total', 
                    class: 'text-center',
                    render: function(data) {
                        return parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                },
                { data: 'created_by_name', name: 'created_by_name', class: 'text-center' }
            ],
            language: {
                lengthMenu: "Tampilkan _MENU_ Data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                search: "Cari :",
                infoFiltered: "(disaring dari total _MAX_ entri)"
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10
        });
    });
</script>
@endsection
