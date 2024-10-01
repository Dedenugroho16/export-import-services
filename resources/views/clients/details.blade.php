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
            <a href="{{ route('consignees.create', $hash) }}" class="btn btn-primary">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah
            </a>
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
                                <th>Name</th>
                                <td>{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $client->address }}</td>
                            </tr>
                            <tr>
                                <th>PO BOX</th>
                                <td>{{ $client->PO_BOX }}</td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td>{{ $client->tel }}</td>
                            </tr>
                            <tr>
                                <th>Fax</th>
                                <td>{{ $client->fax }}</td> 
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
                        @if (session('details_success'))
                            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </div>
                                    <div>
                                        {{ session('details_success') }}
                                    </div>
                                </div>
                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                            </div>
                        @endif

                        <!-- DataTables Integration -->
                        <div class="table-responsive">
                            <table id="consigneeById" class="table card-table table-bordered table-hover table-vcenter text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">ID Client</th>
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
                { data: 'id', name: 'id', class: 'text-center' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address', class: 'text-center' },
                { data: 'tel', name: 'tel', class: 'text-center' },
                { data: 'id_client', name: 'id_client', class: 'text-center' },
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
            pageLength: 10
        });
    });
</script>


@endsection



{{-- @extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 mt-4">
            <a href="{{ route('consignees.create') }}" class="btn btn-primary">
                Tambah
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">
                Kembali
            </a>
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
                                <th>Name</th>
                                <td>{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $client->address }}</td>
                            </tr>
                            <tr>
                                <th>PO BOX</th>
                                <td>{{ $client->PO_BOX }}</td>
                            </tr>
                            <tr>
                                <th>Tel</th>
                                <td>{{ $client->tel }}</td>
                            </tr>
                            <tr>
                                <th>Fax</th>
                                <td>{{ $client->fax }}</td> <!-- Corrected the field from tel to fax -->
                            </tr>
                        </tbody>
                    </table>                   
                </div>
            </div>
        </div>

        <!-- Consignees Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Consignees</h5>
                    </div>
                    <div class="card-body">
                        @if ($client->consignees->isEmpty())
                            <p>Tidak ada consignee untuk client ini.</p>
                        @else
                            <div class="table-responsive">
                                <table id="consigneesTable" class="table table-bordered table-hover table-vcenter">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nama Consignee</th>
                                            <th>Alamat</th>
                                            <th>Telepon</th>
                                            <th class="text-center">Aksi</th> <!-- Added Action Column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->consignees as $consignee)
                                            <tr>
                                                <td>{{ $consignee->name }}</td>
                                                <td>{{ $consignee->address }}</td>
                                                <td>{{ $consignee->tel }}</td>
                                                <td class="text-center"> <!-- Dropdown for Action Buttons -->
                                                    <div class="dropdown">
                                                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('consignees.edit', $consignee->id) }}">Edit</a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('consignees.destroy', $consignee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#consigneesTable').DataTable({
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
            pageLength: 10
        });
    });
</script>
@endsection --}}