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
                        <!-- Table Starts Here -->
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
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
                                    @foreach ($clients as $client)
                                    <tr>
                                        <td class="text-center">{{ $client->id }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td class="text-truncate" style="max-width: 150px;">{{ $client->address }}</td>
                                        <td class="text-center">{{ $client->PO_BOX }}</td>
                                        <td class="text-center">{{ $client->tel }}</td>
                                        <td class="text-center">{{ $client->fax }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('/clients/' . App\Helpers\IdHashHelper::encode($client->id)) }}" class="btn btn-info btn-sm text-white" title="Show">Show</a>
                                            <a href="{{ url('/clients/' . App\Helpers\IdHashHelper::encode($client->id) . '/edit') }}" class="btn btn-warning btn-sm text-white" title="Edit">Edit</a>

                                            <form action="{{ route('clients.destroy', App\Helpers\IdHashHelper::encode($client->id)) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white" title="Delete">
                                                    Delete
                                                    </button>
                                                </form>
                                                </div>
                                            </td>
                                    </tr>
                                    @endforeach
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
