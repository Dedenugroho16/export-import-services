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
                    <path stroke="none" d="M0 0h24V0H0z" fill="none" />
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Tambah
            </a>
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
                                <th class="text-center">Client ID</th>
                                <th class="text-center">Client Company ID</th>
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
            processing: false,
            serverSide: true, 
            ajax: "{{ route('opening-balance.index') }}",
            columns: [
                { 
                    data: null, 
                    class: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1; // Nomor urut
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'payment_number', name: 'payment_number', class: 'text-center' },
                { data: 'date', name: 'date', class: 'text-center' },
                { data: 'id_client', name: 'id_client', class: 'text-center' },
                { data: 'id_client_company', name: 'id_client_company', class: 'text-center' },
                { 
                    data: 'total', 
                    name: 'total', 
                    class: 'text-center',
                    render: function(data) {
                        return parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                },
                { data: 'created_by', name: 'created_by', class: 'text-center' }
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
            pageLength: 10,

            drawCallback: function() {
                $('#openingBalanceTable td:nth-child(2), #openingBalanceTable th:nth-child(2)').css({
                    'max-width': '200px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word'
                });
            }
        });
    });
</script>

<!-- Script Validasi Form dan Alert -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const inputs = form.querySelectorAll('input, select, textarea');
            let isValid = true;

            inputs.forEach(input => {
                if (input.required && !input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault(); // Stop form from submitting
                alert('Harap isi semua field yang diperlukan.');
            }
        });
    });

    // Menghilangkan alert setelah 3 detik
    setTimeout(function() {
        $('.alert-dismissible').fadeOut();
    }, 3000);
});
</script>
@endsection
