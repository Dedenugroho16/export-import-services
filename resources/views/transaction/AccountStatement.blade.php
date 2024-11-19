@extends('layouts.layout')
@section('title', 'Account Statements')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div
                class="mb-4 mt-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <!-- Filter by Stuffing Date -->
                <form class="d-flex flex-column flex-md-row align-items-center mb-3 mb-md-0" method="GET" id="filterForm">
                    <!-- Input Start Date -->
                    <div class="input-group me-md-3 mb-2 mb-md-0" style="width: 250px;">
                        <input type="number" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}" min="1900" max="2099" placeholder="YYYY" required>
                    </div>

                    <!-- Select Company Name -->
                    <div class="input-group me-md-3 mb-2 mb-md-0" style="width: 250px;">
                        <select name="company_name" id="company_name" class="form-select"></select>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex">
                        <button type="button" id="filterBtn" class="btn btn-primary me-2">Filter</button>
                        <a href="{{ route('transactions.AccountStatement') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <!-- Export/Download Button -->
                <div class="dropdown">
                    <button type="button" class="btn btn-warning dropdown-toggle d-flex align-items-center"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                        </svg>
                        Ekspor/Download
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" target="_blank">Expor PDF</a></li>
                        <li><a class="dropdown-item" href="#">Download PDF</a></li>
                    </ul>
                </div>
            </div>
            <div id="error-message" class="alert alert-important alert-danger alert-dismissible" role="alert"
                style="display: none;">
                <div class="d-flex">
                    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg></div>
                    <div>Tolong pilih tanggal terlebih dahulu.</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            <!-- Rekap Section -->
            <div class="card mb-5 shadow-lg" style="border-radius: 5px;">
                <div class="card-body">
                    <!-- Bagian Header -->
                    <div class="text-center mb-5" style="font-family: 'Times New Roman', Times, serif;">
                        <img src="{{ Storage::url('logo1.png') }}" alt="Company Logo"
                            style="max-width: 210px; max-height: 210px;">
                        <h2 class="mb-1"><strong>PT PSN STATEMENT - MEHIO FOR WHOLE SALE<br>YEAR OF 2024</strong></h2>
                    </div>

                    <!-- Row for Invoices and Payments -->
                    <div class="row position-relative" style="display: flex; justify-content: space-between;">
                        <!-- Tabel Invoices -->
                        <div class="col-md-6">
                            <h3 class="text-center mb-4"><strong>INVOICES</strong></h3>
                            <div id="rekap-table" class="table-responsive">
                                <table class="table table-borderless table-vcenter table-nowrap" id="rekapTable"
                                    style="border-collapse: collapse;">
                                    <thead class="border-end border-dark">
                                        <tr>
                                            <th class="text-center" style="text-decoration: underline;">DATE</th>
                                            <th class="text-center" style="text-decoration: underline;">INVOICE NO</th>
                                            <th class="text-center" style="text-decoration: underline;">AMOUNT USD</th>
                                            <th class="text-center" style="text-decoration: underline;">BALANCE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-end border-dark">
                                        <tr>
                                            <td class="text-center">2024-11-01</td>
                                            <td class="text-center">INV12345</td>
                                            <td class="text-center">$1000</td>
                                            <td class="text-center">$500</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2024-11-05</td>
                                            <td class="text-center">INV12346</td>
                                            <td class="text-center">$1500</td>
                                            <td class="text-center">$800</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2024-11-10</td>
                                            <td class="text-center">INV12347</td>
                                            <td class="text-center">$2000</td>
                                            <td class="text-center">$1200</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Payments -->
                        <div class="col-md-6">
                            <h3 class="text-center mb-4"><strong>PAYMENTS</strong></h3>
                            <div id="payment-table" class="table-responsive">
                                <table class="table table-borderless table-vcenter table-nowrap" id="paymentTable"
                                    style="border-collapse: collapse;">
                                    <thead class="border-start border-dark">
                                        <tr>
                                            <th class="text-center" style="text-decoration: underline;">DATE</th>
                                            <th class="text-center" style="text-decoration: underline;">DESCRIPTION</th>
                                            <th class="text-center" style="text-decoration: underline;">PAYMENT USD</th>
                                            <th class="text-center" style="text-decoration: underline;">BALANCE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-start border-dark">
                                        <tr>
                                            <td class="text-center">2024-11-02</td>
                                            <td class="text-center">Payment for INV12345</td>
                                            <td class="text-center">$500</td>
                                            <td class="text-center">$0</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2024-11-06</td>
                                            <td class="text-center">Payment for INV12346</td>
                                            <td class="text-center">$800</td>
                                            <td class="text-center">$0</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2024-11-12</td>
                                            <td class="text-center">Payment for INV12347</td>
                                            <td class="text-center">$1200</td>
                                            <td class="text-center">$0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#company_name').select2({
                        placeholder: 'Select a company',
                        allowClear: true,
                        width: '100%',
                        ajax: {
                            url: "{{ route('clients.list') }}",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    search: params.term, // Istilah pencarian
                                    page: params.page || 1 // Halaman yang diminta
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data.results.map(item => ({
                                        id: item.id,
                                        text: item.company_name
                                    })),
                                    pagination: {
                                        more: data.pagination.more
                                    }
                                };
                            },
                            cache: true
                        }
                    });
                });
            </script>
        @endsection
