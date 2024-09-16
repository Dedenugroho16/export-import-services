@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Detail Product : {{ $product->name }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Nama</th>
                <th class="text-center">Pcs</th>
                <th class="text-center">Dimensi</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Warna</th>
                <th class="text-center">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product->detailProducts as $detail)
            <tr>
                <td>{{ $detail->name }}</td>
                <td>{{ $detail->pcs }}</td>
                <td>{{ $detail->dimension }}</td>
                <td>{{ $detail->type }}</td>
                <td>{{ $detail->color }}</td>
                <td>{{ $detail->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
