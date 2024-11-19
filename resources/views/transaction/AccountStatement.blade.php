@extends('layouts.layout')
@section('title', 'Account Statements')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div
                class="mb-4 mt-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <!-- Filter by Stuffing Date -->
                <form class="row align-items-center gy-2 gx-2 mb-3" method="GET" id="filterForm">
                    <!-- Input Tahun -->
                    <div class="col-auto">
                        <label for="yearSelect" class="form-label mb-0" style="font-size: 0.9rem;">Pilih Tahun</label>
                        <select name="year" id="yearSelect" class="form-select">
                            <script>
                                const yearSelect = $('#yearSelect');
                                for (let year = new Date().getFullYear(); year <= new Date().getFullYear() + 99; year++) {
                                    yearSelect.append(`<option value="${year}">${year}</option>`);
                                }
                            </script>
                        </select>
                    </div>

                    <!-- Select Nama Perusahaan -->
                    <div class="col-auto">
                        <label for="company_name" class="form-label mb-0" style="font-size: 0.9rem;">Pilih
                            Perusahaan</label>
                        <select name="company_name" id="company_name" class="form-select">
                        </select>
                    </div>

                    <!-- Tombol Filter dan Reset -->
                    <div class="col-auto d-flex align-items-end">
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
                        <img src="{{ asset('storage/logo1.png') }}" alt="Company Logo"
                            style="max-width: 210px; max-height: 210px;">
                        <h2 class="mb-1" style="text-decoration: underline;"><strong id="companyStatement">PT PSN
                                STATEMENT - <br>YEAR OF
                                2024</strong></h2>
                    </div>

                    <!-- Row for Invoices and Payments -->
                    <div class="row position-relative" style="display: flex; justify-content: space-between;">
                        <!-- Tabel Invoices -->
                        <div class="col-md-6">
                            <h3 class="text-center mb-4" style="text-decoration: underline;"><strong>INVOICES</strong></h3>
                            <div id="rekap-table" class="table-responsive">
                                <table class="table table-borderless table-vcenter table-nowrap" id="invoicesTable"
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
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Payments -->
                        <div class="col-md-6">
                            <h3 class="text-center mb-4" style="text-decoration: underline;"><strong>PAYMENTS</strong>
                            </h3>
                            <div id="payment-table" class="table-responsive">
                                <table class="table table-borderless table-vcenter table-nowrap" id="paymentsTable"
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#yearSelect').select2({
                        placeholder: "Pilih Tahun",
                        allowClear: true,
                        width: '100%' // Membuat Select2 full size
                    });

                    $('#company_name').select2({
                        ajax: {
                            url: "{{ route('clients.list') }}", // Endpoint backend
                            dataType: 'json',
                            delay: 250, // Debounce untuk mengurangi beban server
                            data: function(params) {
                                return {
                                    search: params.term, // Kirim input pencarian ke server
                                    page: params.page || 1 // Untuk pagination jika ada
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data.results, // Ambil hasil yang relevan
                                    pagination: {
                                        more: data.pagination.more // Atur pagination
                                    }
                                };
                            }
                        },
                        placeholder: 'Select a company',
                        width: '100%',
                        minimumInputLength: 1, // Mulai pencarian setelah 1 karakter
                        allowClear: true
                    });


                    // $('#company_name').on('select2:select', function(e) {
                    //     let companyName = e.params.data.text; // Ambil nama perusahaan dari Select2
                    //     let year = $('#yearSelect').val(); // Ambil tahun dari input

                    //     // Update teks pada elemen
                    //     $('#companyStatement').html(
                    //         `PT PSN STATEMENT - ${companyName}<br>YEAR OF ${year}`);
                    // });

                    $('#company_name').on('select2:select', function(e) {
                        let companyName = e.params.data.text; // Ambil nama perusahaan dari Select2
                        let year = $('#yearSelect').val(); // Ambil tahun dari input

                        // Update teks pada elemen
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - ${companyName}<br>YEAR OF ${year}`
                        );
                    });

                    // Tangani saat Select2 di-clear
                    $('#company_name').on('select2:clear', function() {
                        let year = $('#yearSelect').val(); // Tetap ambil tahun dari input jika ada
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - <br>YEAR OF ${year}` // Hanya tampilkan tahun tanpa nama perusahaan
                        );
                    });

                    $('#yearSelect').on('input', function() {
                        let year = $(this).val(); // Ambil nilai input tahun
                        let companyName = $('#company_name').select2('data')[0]?.text ||
                            ''; // Ambil nama perusahaan atau default

                        // Update teks pada elemen
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - ${companyName}<br>YEAR OF ${year}`);
                    });
                });
            </script>
        @endsection
