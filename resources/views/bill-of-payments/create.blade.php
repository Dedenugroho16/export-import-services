@extends('layouts.layout')
@section('title', 'Bill of Payment')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Bill of Payment</h3>
                        </div>
                        <div class="card-body">
                            <!-- Display Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
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
                            @endif

                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Month</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p>{{ date('F Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>No. Inv</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="no-inv-display">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Buyer Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Company Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="table card-table table-vcenter text-nowrap" id="clientsModalTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">PI. NUMBER</th>
                                                    <th class="text-center">CODE</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">PAID</th>
                                                    <th class="text-center">BILL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-6">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <h3>REMITTANCE ADVICE</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Account Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p>{{ date('F Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Account Number USD</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="product-code">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Bank Name</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Beneficiary Bank Address</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>Swift Code</p>
                                                    </div>
                                                    <div class="col-1 text-center">
                                                        <span>:</span>
                                                    </div>
                                                    <div class="col-5">
                                                        <p id="numberDisplay">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payments.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function updateNumber() {
                const currentDate = new Date();

                const twoDigitMonth = ('0' + (currentDate.getMonth() + 1)).slice(-2);

                const romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                const romanMonth = romanMonths[currentDate.getMonth()];

                // Dapatkan tahun dalam format dua digit
                const twoDigitYear = currentDate.getFullYear().toString().slice(-2);

                // Cek apakah productAbbreviation dan countryCode ada
                if (productAbbreviation && countryCode) {
                    const formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    const finalNumber = '{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber;
                    $('#numberDisplay').text(finalNumber);
                    $('#number').val(finalNumber); // Setel nilai input
                } else if (productAbbreviation) {
                    const formattedNumber = '/' + twoDigitMonth + '/INV/' + romanMonth + '/' + twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + '.' + productAbbreviation + ' ' +
                        formattedNumber);
                } else if (countryCode) {
                    const formattedNumber = countryCode + '/' + twoDigitMonth + '/INV/' + romanMonth + '/' +
                        twoDigitYear;
                    $('#numberDisplay').text('{{ $formattedNumber }}' + ' ' + formattedNumber);
                } else {
                    $('#numberDisplay').text('{{ $formattedNumber }}');
                }
            }

            updateNumber();
        });
    </script>
@endsection
