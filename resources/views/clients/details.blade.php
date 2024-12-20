@extends('layouts.layout')
@section('title', 'Consignee')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 mt-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                Kembali
            </a>
            @if(in_array(auth()->user()->role, ['admin', 'operator']))
                <a href="{{ route('consignees.create', $hash) }}" class="btn btn-primary">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Tambah
                </a>
            @endif
        </div>
        <div class="card mb-5">
            <div class="card-header shadow-sm p-3">
                <h3 class="card-title">Informasi Client</h3>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama Client</th>
                                <td>{{ $client->name }}</td>
                            </tr>
                        </tbody>
                    </table>                   
                    
                </div>
            </div>
        </div>
        <!-- Product Details Table -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Success Message for Deleting, Editing, or Adding Data -->
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
                        <!-- DataTables Integration -->
                        <div class="table-responsive">
                            <table id="consigneeById" class="table card-table table-hover table-vcenter text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Aksi</th>
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

<!-- DataTables Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#consigneeById').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('clients.details', $hash) }}",
                type: 'GET'
            },
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
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address'},
                { data: 'tel', name: 'tel', class: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
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
                // Terapkan style khusus untuk kolom kedua (name) dan kolom ketiga (address)
                $('#consigneeById td:nth-child(2), #consigneeById th:nth-child(2)').css({
                    'max-width': '200px',
                    'white-space': 'normal',
                    'word-wrap': 'break-word'
                });
                $('#consigneeById td:nth-child(3), #consigneeById th:nth-child(3)').css({
                    'max-width': '250px',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis'
                });
            }
        });
    });

$(document).ready(function() {
        setTimeout(function() {
            $('.alert-dismissible').fadeOut();
        }, 3000);
    });
</script>
@endsection