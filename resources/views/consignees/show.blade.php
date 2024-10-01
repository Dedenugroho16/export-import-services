@extends('layouts.layout')
@section('title', 'Consignee')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Informasi Consignee</h3>
                        <!-- Dropdown Button -->
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- SVG Icon -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            </a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ url('/consignees/' . App\Helpers\IdHashHelper::encode($consignee->id) . '/edit') }}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </a>
                                <form action="{{ route('consignees.destroy', \App\Helpers\IdHashHelper::encode($consignee->id)) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus consignee ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; display: block; width: 100%; text-align: left;">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        Delete
                                    </button>
                                </form>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $consignee->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Consignee</th>
                                        <td>{{ $consignee->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td style="word-wrap: break-word; max-width: 300px;">{{ $consignee->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>{{ $consignee->tel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Client</th>
                                        <td>{{ $consignee->client->name }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-5 d-flex justify-content-end">
                                <a href="javascript:window.history.back();" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection