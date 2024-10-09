@extends('layouts.layout')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Transaksi</h3>
                        </div>
                        <div class="card-body">
                            {{-- <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('transaction_id'))
                                <div class="alert alert-info">
                                    Transaction ID: {{ session('transaction_id') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            {{-- Bagian 1 --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">INVOICE</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <p><strong>Date</strong></p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="col-5">
                                                            <p>{{ $transaction->date }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <p><strong>Code</strong></p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="col-5">
                                                            <p id="product-code">{{ $transaction->code }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <p><strong>Number</strong></p>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <span>:</span>
                                                        </div>
                                                        <div class="col-5">
                                                            <p id="numberDisplay">{{ $transaction->number }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formTransaction" method="POST"
                                action="{{ route('transaction.update', ['id' => $transaction->id]) }}">
                                @csrf
                                @method('PUT')

                                <input type="date" name="date" id="date" value="{{ $transaction->date }}" hidden>
                                <input type="text" name="code" id="code" value="{{ $transaction->code }}" hidden>
                                <input type="text" name="number" id="number" value="{{ $transaction->number }}"
                                    hidden>
                                <input type="number" name="freight_cost" id="freight_cost"
                                    value="{{ $transaction->freight_cost }}" hidden>
                                <input type="number" name="total" id="total" value="{{ $transaction->total }}"
                                    hidden>
                                <input type="number" name="approved" id="approved" value="{{ $transaction->approved }}"
                                    hidden>

                                <!-- Bagian 2: Consignee, Notify, Client -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Parties Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Client Input -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="clientName">Client :</label>
                                                    <input type="text" class="form-control" id="clientName"
                                                        value="{{ $transaction->client->name }}" disabled>
                                                    <input type="hidden" name="id_client"
                                                        value="{{ $transaction->id_client }}">
                                                </div>
                                                <!-- Element to display the address -->
                                                <div id="client-address" style="margin-top: 10px;">
                                                    {{ $transaction->client->address }}</div>
                                            </div>

                                            <!-- Notify Input -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="notify">Notify</label>
                                                    <input type="text" id="notify" class="form-control"
                                                        value="{{ $transaction->notify }}" disabled>
                                                    <input type="hidden" name="notify"
                                                        value="{{ $transaction->notify }}">
                                                </div>
                                            </div>

                                            <!-- Consignee Input -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="consigneeName">Consignee :</label>
                                                    <input type="text" class="form-control" id="consigneeName"
                                                        value="{{ $transaction->consignee->name }}" disabled>
                                                    <input type="hidden" name="id_consignee"
                                                        value="{{ $transaction->id_consignee }}">
                                                </div>
                                                <!-- Element to display the address -->
                                                <div id="client-address" style="margin-top: 10px;">
                                                    {{ $transaction->consignee->address }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Bagian 3: Port of Loading, Place of Receipt, Port of Discharge, Place of Delivery -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Logistics Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Port of Loading Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_loading">Port of Loading</label>
                                                    <input type="text" class="form-control" id="port_of_loading"
                                                        value="{{ $transaction->port_of_loading }}" disabled>
                                                    <input type="hidden" name="port_of_loading"
                                                        value="{{ $transaction->port_of_loading }}">
                                                </div>
                                            </div>

                                            <!-- Place of Receipt Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_receipt">Place of Receipt</label>
                                                    <input type="text" class="form-control" id="place_of_receipt"
                                                        value="{{ $transaction->place_of_receipt }}" disabled>
                                                    <input type="hidden" name="place_of_receipt"
                                                        value="{{ $transaction->place_of_receipt }}">
                                                </div>
                                            </div>

                                            <!-- Port of Discharge Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_discharge">Port of Discharge</label>
                                                    <input type="text" class="form-control" id="port_of_discharge"
                                                        value="{{ $transaction->port_of_discharge }}" disabled>
                                                    <input type="hidden" name="port_of_discharge"
                                                        value="{{ $transaction->port_of_discharge }}">
                                                </div>
                                            </div>

                                            <!-- Place of Delivery Input -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_delivery">Place of Delivery</label>
                                                    <input type="text" class="form-control" id="place_of_delivery"
                                                        value="{{ $transaction->place_of_delivery }}" disabled>
                                                    <input type="hidden" name="place_of_delivery"
                                                        value="{{ $transaction->place_of_delivery }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- bagian 4 --}}
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">DETAILS</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Kolom Sebelah Kiri -->
                                            <div class="col-6">
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Name of Product</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->product->name }}" disabled>
                                                        <input type="hidden" name="id_product"
                                                            value="{{ $transaction->id_product }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Name of Commodity</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->commodity->name }}" disabled>
                                                        <input type="hidden" name="id_commodity"
                                                            value="{{ $transaction->id_commodity }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Container</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->container }}" disabled>
                                                        <input type="hidden" name="container"
                                                            value="{{ $transaction->container }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Net Weight</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->net_weight }}" disabled>
                                                        <input type="hidden" name="net_weight"
                                                            value="{{ $transaction->net_weight }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Gross Weight</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->gross_weight }}" disabled>
                                                        <input type="hidden" name="gross_weight"
                                                            value="{{ $transaction->gross_weight }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Payment Term</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->payment_term }}" disabled>
                                                        <input type="hidden" name="payment_term"
                                                            value="{{ $transaction->payment_term }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Kolom Sebelah Kanan -->
                                            <div class="col-6">
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Stuffing Date</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="date" name="stuffing_date" id="stuffing_date"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>BL Number</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" name="bl_number" id="bl_number"
                                                            class="form-control" placeholder="Masukkan BL Number"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Container Number</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" name="container_number"
                                                            id="container_number" class="form-control"
                                                            placeholder="Masukkan Container Number" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Seal Number</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" name="seal_number" id="seal_number"
                                                            class="form-control" placeholder="Masukkan Seal Number"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <p><strong>Product NCM</strong></p>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $transaction->product_ncm }}" disabled>
                                                        <input type="hidden" name="product_ncm"
                                                            value="{{ $transaction->product_ncm }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- tabel detail transaction --}}
                            <div class="tabel-detail-transaksi mt-4">
                                <div class="table-responsive pb-2 border-top" style="max-height: 18rem">
                                    <table class="table table-bordered table-hover table-striped table-sm"
                                        id="tableDetailTransaction">
                                        <thead>
                                            <th class="text-center">Item Description</th>
                                            <th class="text-center">Carton(pcs)</th>
                                            <th class="text-center">Inner(pcs)</th>
                                            <th class="text-center">Unit Price(USD/KG)</th>
                                            <th class="text-center">Net Weight(KG)</th>
                                            <th class="text-center">Price Amount(USD)</th>
                                        </thead>
                                        <tbody id="detail-rows" style="font-size: 12px">
                                            @foreach ($detailTransactions as $detailTransaction)
                                                <tr>
                                                    <td>{{ $detailTransaction->detailProduct->name }}</td>
                                                    <td class="carton">{{ $detailTransaction->carton }}</td>
                                                    <td class="inner">{{ $detailTransaction->inner_qty_carton }}</td>
                                                    <td>{{ $detailTransaction->unit_price }}</td>
                                                    <td class="net-weight">{{ $detailTransaction->net_weight }}</td>
                                                    <td class="price-amount">{{ $detailTransaction->price_amount }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr id="totalRow" style="font-weight: bold;">
                                                <td class="text-center">Amount</td>
                                                <td class="text-center" id="totalCarton">0</td>
                                                <td class="text-center" id="totalInner">0</td>
                                                <td class="text-center"></td>
                                                <td class="text-center" id="totalNetWeight">0</td>
                                                <td class="text-center" id="PriceAmount">0</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5"></td>
                                                <td class="text-center">
                                                    <p>Freight cost : {{ $transaction->freight_cost }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5"></td>
                                                <td class="text-center">
                                                    <p>Total : {{ $transaction->total }}</p>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-2">
                                <a href="{{ url('/proforma') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButtonTransaction"
                                    class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function updateAmounts() {
                var totalCarton = 0;
                var totalInner = 0;
                var totalNetWeight = 0;
                var PriceAmount = 0;

                // Iterasi setiap baris untuk mendapatkan nilai total
                $('#tableDetailTransaction tbody tr').each(function() {
                    var carton = parseFloat($(this).find('.carton').text()) || 0;
                    var inner = parseFloat($(this).find('.inner').text()) || 0;
                    var netWeight = parseFloat($(this).find('.net-weight').text()) || 0;
                    var price = parseFloat($(this).find('.price-amount').text()) || 0;

                    totalCarton += carton;
                    totalInner += inner;
                    totalNetWeight += netWeight;
                    PriceAmount += price;
                });

                // Update nilai total di footer
                $('#totalCarton').text(totalCarton);
                $('#totalInner').text(totalInner);
                $('#totalNetWeight').text(totalNetWeight);
                $('#PriceAmount').text(PriceAmount);
            }
            updateAmounts();

            $('#submitButtonTransaction').click(function(e) {
                e.preventDefault(); // Mencegah form dari submit default

                var formTransaction = $('#formTransaction');
                var formData = formTransaction.serialize(); // Mengambil data dari form

                $.ajax({
                    url: formTransaction.attr('action'), // Mengambil URL dari form action
                    method: 'PUT', // Menggunakan method PUT
                    data: formData,
                    success: function(response) {
                        // Pastikan response sukses dan ID transaksi dikembalikan
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Invoice berhasil dibuat',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                    '/transaction'; // Arahkan ke route /transaction setelah sukses
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal membuat invoice: ' + response
                                    .message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Tangani error untuk transaksi
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error membuat invoice: ' + xhr.responseJSON
                                .message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

        });
    </script>
@endsection
