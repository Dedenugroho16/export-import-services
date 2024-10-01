@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Data Consignee</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Edit Form -->
                        <form action="{{ route('consignees.update', \App\Helpers\IdHashHelper::encode($consignee->id)) }}" method="POST">
                            @csrf
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Consignee</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $consignee->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" class="form-control" required>{{ old('address', $consignee->address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tel" class="form-label">Telepon</label>
                                <input type="text" id="tel" name="tel" class="form-control" value="{{ old('tel', $consignee->tel) }}" required>
                            </div>
                            <div class="mb-5">
                                <label for="id_client" class="form-label">ID Client</label>
                                <select name="id_client" id="id_client" class="form-control" required>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $client->id == $consignee->id_client ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('consignees.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
