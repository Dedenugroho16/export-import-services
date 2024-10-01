@extends('layouts.layout')

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
@endsection