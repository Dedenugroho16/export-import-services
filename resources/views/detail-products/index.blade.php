@extends('layouts.layout')
@section('title', 'Detail Produk')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header and Add Detail Product Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('detail-products.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Detail Produk
            </a>
        </div>
        
        <!-- Detail Products Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Success and Error Alerts -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Data Table -->
                        <div class="table-responsive">
                            <table id="myTable" class="table card-table table-vcenter text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID Product</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Pcs</th>
                                        <th class="text-center">Dimension</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Color</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#myTable').DataTable({
            serverSide: true,
            ajax: '{{ route('detail-products.index') }}',
            columns: [
                { data: 'id_product', name: 'id_product', className: 'text-center' },
                { data: 'name', name: 'name' },
                { data: 'pcs', name: 'pcs', className: 'text-center' },
                { data: 'dimension', name: 'dimension', className: 'text-center' },
                { data: 'type', name: 'type', className: 'text-center' },
                { data: 'color', name: 'color', className: 'text-center' },
                { data: 'price', name: 'price' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            language: {
                        lengthMenu: "Tampilkan _MENU_ entri",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
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
                                // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
                                $('#myTable td:nth-child(2)').css({
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'
                                });

                                $('#myTable td:nth-child(4), #myTable td:nth-child(7)').css({
                                    'max-width': '200px',
                                    'overflow': 'hidden',
                                    'text-overflow': 'ellipsis'
                                });
                            }
        });
    });
    </script>
    
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
                alert('Please fill in all required fields.');
            }
        });
    });
});
</script>

@endsection
