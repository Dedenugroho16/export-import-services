@extends('layouts.layout')
@section('title', 'Detail Produk')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header shadow-sm p-3">
                        <h3 class="card-title">Informasi Detail Produk</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $detailProduct->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <td>{{ $detailProduct->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Produk</th>
                                        <td>{{ $detailProduct->product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>PCS</th>
                                        <td>{{ $detailProduct->pcs }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensi</th>
                                        <td>{{ $detailProduct->dimension }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tipe</th>
                                        <td>{{ $detailProduct->type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Warna</th>
                                        <td>{{ $detailProduct->color }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>{{ number_format($detailProduct->price, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="mt-4 d-flex justify-content-end">
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