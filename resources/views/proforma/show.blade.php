{{-- @extends('layouts.layout')

@section('title', 'Detail Proforma Invoice')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Proforma Invoice</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Consignee:</strong></h6>
                                <p>
                                    {{ $proformaInvoice->consignee->name }} <br>
                                    {{ $proformaInvoice->consignee->address }} <br>
                                    Tel: {{ $proformaInvoice->consignee->phone }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Client:</strong></h6>
                                <p>
                                    {{ $proformaInvoice->client->name }} <br>
                                    {{ $proformaInvoice->client->address }} <br>
                                    Tel: {{ $proformaInvoice->client->phone }}
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Port of Loading:</strong></h6>
                                <p>{{ $proformaInvoice->port_of_loading }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Port of Discharge:</strong></h6>
                                <p>{{ $proformaInvoice->port_of_discharge }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Place of Delivery:</strong></h6>
                                <p>{{ $proformaInvoice->place_of_delivery }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Container:</strong></h6>
                                <p>{{ $proformaInvoice->container }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Payment Term:</strong></h6>
                                <p>{{ $proformaInvoice->payment_term }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Freight Cost:</strong></h6>
                                <p>${{ number_format($proformaInvoice->freight_cost, 2) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6><strong>Item Description:</strong></h6>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Carton (PCS)</th>
                                            <th>Inner (PCS)</th>
                                            <th>Unit Price (USD/KG)</th>
                                            <th>Net Weight (KG)</th>
                                            <th>Price Amount (USD)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop data produk yang terkait dengan Proforma Invoice -->
                                        @foreach ($proformaInvoice->products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->pivot->carton }}</td>
                                                <td>{{ $product->pivot->inner }}</td>
                                                <td>${{ number_format($product->pivot->unit_price, 2) }}</td>
                                                <td>{{ $product->pivot->net_weight }}</td>
                                                <td>${{ number_format($product->pivot->price_amount, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6><strong>Total Amount:</strong></h6>
                                <p>${{ number_format($proformaInvoice->total, 2) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6><strong>Terms & Conditions:</strong></h6>
                                <p>{{ $proformaInvoice->terms_conditions }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <p><strong>Total Amount in Words:</strong> {{ ucwords(\App\Helpers\NumberToWords::convert($proformaInvoice->total)) }} USD</p>
                                <p><strong>Payment Condition:</strong> FOB (Free On Board)</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<h1>Proforma Show</h1>