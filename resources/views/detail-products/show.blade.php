@extends('layouts.layout')
@section('title', 'Detail Produk')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
                <div class="col-12">
                    <!-- Success Message for Deleting, Editing, or Adding Data -->
                    @if (session('success'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                </div>
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <div class="card mb-5">
                        <div class="card-header shadow-sm p-3 d-flex justify-content-between align-items-centerd">
                            <h3 class="card-title">Informasi Detail Produk</h3>
                            <a class="btn btn-light"
                                href="{{ url('/detail-products/' . App\Helpers\IdHashHelper::encode($detailProduct->id) . '/edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Edit
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 20%;">Nama Produk</th>
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
                                    <a href="{{ route('products.details', $hashedProductId) }}"
                                        class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-dismissible').fadeOut();
            }, 3000);
        });
    </script>
@endsection
