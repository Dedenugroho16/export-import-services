@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Dashboard Header and Add Client Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Client
            </a>
        </div>
        <!-- Clients Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <!-- Success Message for Deleting, Editing, or Adding Client -->
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
                        <!-- Table Starts Here -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap" id="clientTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">PO BOX</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Fax</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#clientTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: "{{ route('clients.index') }}",
                 columns: [
                    { data: 'id', name: 'id', class: 'text-center' },
                    { data: 'name', name: 'name'},
                    { data: 'address', name: 'address' },
                    { data: 'PO_BOX', name: 'PO_BOX', class: 'text-center' },
                    { data: 'tel', name: 'tel', class: 'text-center' },
                    { data: 'fax', name: 'fax', class: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
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
                                $('#clientTable td:nth-child(2), #clientTable th:nth-child(2)').css({
                                    'max-width': '200px',
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'
                                });
                                $('#clientTable td:nth-child(3), #clientTable th:nth-child(3)').css({
                                    'max-width': '250px',
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
