@extends('layouts.layout')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                            <h3 class="card-title">Form Transaksi</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form>
                                @csrf

                                {{-- Bagian 1 --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4>INVOICE - NUMBER</h4>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#pendingPaymentModal">
                                                        <i data-feather="search"></i> Transaksi Pending
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#memberModal">
                                                        <i data-feather="search"></i> Cari Pelanggan
                                                    </button>
                                                </div>
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
                                                                <p>{{ date('d F Y') }}</p>
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
                                                                <p id="invoice_num">-</p>
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
                                                                <p id="invoice_num">-</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian 2: Consignee, Notify, Client -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Parties Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="client">Client</label>
                                                    <select class="form-control client" id="client">
                                                        <option value="">Pilih Client</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="notify">Notify</label>
                                                    <input type="text" id="notify" class="form-control"
                                                        placeholder="Enter notify party">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="consignee">Consignee</label>
                                                    <select class="form-control consignee" id="consignee" name="consignee[]"
                                                        multiple="multiple">
                                                        @foreach ($consignees as $consignee)
                                                            <option value="{{ $consignee->id }}"
                                                                data-id-client="{{ $consignee->id_client }}">
                                                                {{ $consignee->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_loading">Port of Loading</label>
                                                    <input type="text" id="port_of_loading" class="form-control"
                                                        placeholder="Enter port of loading">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_receipt">Place of Receipt</label>
                                                    <input type="text" id="place_of_receipt" class="form-control"
                                                        placeholder="Enter place of receipt">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="port_of_discharge">Port of Discharge</label>
                                                    <input type="text" id="port_of_discharge" class="form-control"
                                                        placeholder="Enter port of discharge">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="place_of_delivery">Place of Delivery</label>
                                                    <input type="text" id="place_of_delivery" class="form-control"
                                                        placeholder="Enter place of delivery">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- bagian 4 --}}
                                <div class="card mt-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <h4>DETAILS</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Kolom Sebelah Kiri -->
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Name of Product</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="productName">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Name of Commodity</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="commodityName">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Container</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="container">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Net Weight</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="netWeight">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Gross Weight</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="grossWeight">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Payment Term</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="paymentTerm">-</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Kolom Sebelah Kanan -->
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Stuffing Date</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="stuffingDate">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>BL Number</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="blNumber">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Container Number</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="containerNumber">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Seal Number</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="sealNumber">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <p><strong>Product NCM</strong></p>
                                                    </div>
                                                    <div class="col-3 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="productNcm">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4>Transaction Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Item Description</th>
                                                        <th>Carton (pcs)</th>
                                                        <th>Inner (pcs)</th>
                                                        <th>Unit Price (USD / KG)</th>
                                                        <th>Net Weight (KG)</th>
                                                        <th>Price Amount (USD)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="item_description[]" placeholder="Item Description">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="carton_pcs[]" placeholder="Carton (pcs)">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="inner_pcs[]"
                                                                placeholder="Inner (pcs)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="unit_price[]" placeholder="Unit Price (USD / KG)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="net_weight[]" placeholder="Net Weight (KG)">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control"
                                                                name="price_amount[]" placeholder="Price Amount (USD)">
                                                        </td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Tombol Submit -->
                            <div class="card-body text-end">
                                <button type="submit" class="btn btn-primary">Submit Invoice</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk kedua dropdown
            $('#client').select2();
            $('#consignee').select2({
                placeholder: "Pilih consignee",
                allowClear: true
            });

            // Ketika client dipilih
            $('#client').on('change', function() {
                var clientId = $(this).val(); // Dapatkan id client yang dipilih
                // console.log('Client selected: ', clientId);

                // Reset opsi yang ada dan tandai opsi yang cocok dengan id_client
                $('#consignee option').each(function() {
                    var option = $(this);
                    var idClientOption = option.data(
                        'id-client'); // Ambil data-id-client dari tiap option

                    if (idClientOption == clientId) {
                        option.prop('selected', true); // Pilih opsi yang sesuai
                    } else {
                        option.prop('selected', false); // Hapus seleksi dari opsi yang tidak cocok
                    }
                });

                // Update Select2
                $('#consignee').trigger('change');
            });
        });
    </script>
@endsection
