@extends('layouts.layout')
@section('title', 'Account Statements')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div
                class="mb-4 mt-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <form class="row align-items-center gy-2 gx-3 mb-3" method="GET" id="filterForm">
                    <!-- Input Tahun -->
                    <div class="col-sm-12 col-md-4">
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
                    <div class="col-sm-12 col-md-4">
                        <label for="company_id" class="form-label mb-0" style="font-size: 0.9rem;">Pilih
                            Perusahaan</label>
                        <select name="company_id" id="company_id" class="form-select">
                        </select>
                    </div>

                    <!-- Tombol Filter dan Reset -->
                    <div class="col-sm-12 col-md-4 d-flex align-items-end">
                        <button type="button" id="filterBtn"
                            class="btn btn-primary w-100 w-md-auto me-md-2">Filter</button>
                        <a id="resetBtn" class="btn btn-secondary w-100 w-md-auto">Reset</a>
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
                    <div>Tolong atur filter terlebih dahulu.</div>
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
                            <div id="rekap-table" class="table-responsive" style="overflow: hidden; width: 100%;">
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
                                    <tfoot>
                                        <tr id="totalBalance" style="font-weight: bold;">
                                            <td class="text-center">TOTAL</td>
                                            <td colspan="2"></td>
                                            <td class="text-center" id="totalBalanceInvoice">0</td>
                                        </tr>
                                    </tfoot>
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
                                    <tfoot>
                                        <tr id="totalBalance" style="font-weight: bold;">
                                            <td class="text-center">TOTAL</td>
                                            <td colspan="2"></td>
                                            <td class="text-center" id="totalBalancePayment">0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-6">
                            <div class="border border-dark px-1 py-1 bg-light text-center">
                                <h4 class="m-0">BALANCE: <span id="balanceValue">0</span></h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                $(document).ready(function() {
                    function updateBalance() {
                        // Ambil nilai dari totalBalanceInvoice dan totalBalancePayment
                        let totalInvoice = parseFloat($('#totalBalanceInvoice').text().replace(/,/g, '')) || 0;
                        let totalPayment = parseFloat($('#totalBalancePayment').text().replace(/,/g, '')) || 0;

                        // Hitung balance
                        let balance =  totalPayment - totalInvoice;

                        // Format hasil menggunakan Intl.NumberFormat
                        let formattedBalance = new Intl.NumberFormat('en-US', {
                            style: 'decimal'
                        }).format(balance);

                        // Tampilkan hasil ke elemen
                        $('#balanceValue').text(formattedBalance);
                    }

                    $('#yearSelect').select2({
                        placeholder: "Pilih Tahun",
                        allowClear: true,
                        width: '100%' // Membuat Select2 full size
                    });

                    $('#company_id').select2({
                        placeholder: 'Select a Company',
                        ajax: {
                            url: '{{ route('client-companies.get') }}',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    search: params.term, // Kata kunci pencarian
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data.results, // Data untuk ditampilkan
                                };
                            },
                            cache: true,
                        },
                    });

                    $('#company_id').on('select2:select', function(e) {
                        let companyName = e.params.data.text; // Ambil nama perusahaan dari Select2
                        let year = $('#yearSelect').val(); // Ambil tahun dari input

                        // Update teks pada elemen
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - ${companyName}<br>YEAR OF ${year}`
                        );
                    });

                    // Tangani saat Select2 di-clear
                    $('#company_id').on('select2:clear', function() {
                        let year = $('#yearSelect').val();
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - <br>YEAR OF ${year}`
                        );
                    });

                    $('#yearSelect').on('input', function() {
                        let year = $(this).val(); // Ambil nilai input tahun
                        let companyName = $('#company_id').select2('data')[0]?.text ||
                            ''; // Ambil nama perusahaan atau default

                        // Update teks pada elemen
                        $('#companyStatement').html(
                            `PT PSN STATEMENT - ${companyName}<br>YEAR OF ${year}`);
                    });

                    // Inisialisasi DataTable
                    let table = $('#invoicesTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ url('/transactions/AccountStatement/invoices-data') }}',
                            data: function(d) {
                                d.year = $('#yearSelect').val();
                                d.company_id = $('#company_id').val();
                            }
                        },
                        columns: [{
                                data: 'date',
                                className: 'text-center'
                            },
                            {
                                data: 'number',
                                className: 'text-center'
                            },
                            {
                                data: 'total',
                                className: 'text-center',
                                render: function(data) {
                                    return new Intl.NumberFormat('en-US', {
                                        style: 'decimal'
                                    }).format(data); // Format the balance value
                                }
                            },
                            {
                                data: 'balance',
                                className: 'text-center',
                                render: function(data) {
                                    return '<b>' + new Intl.NumberFormat('en-US', {
                                        style: 'decimal'
                                    }).format(data) + '</b>'; // Format the balance value with bold font
                                }
                            }
                        ],
                        order: [
                            [0, 'asc']
                        ], // Sort by DATE ascending
                        pageLength: 10,
                        footerCallback: function(row, data, start, end, display) {
                            // Hitung total balance untuk invoices
                            let totalBalanceInvoice = 0;
                            data.forEach(function(item) {
                                totalBalanceInvoice += parseFloat(item.total || 0);
                            });

                            // Format total balance dengan Intl.NumberFormat
                            let formattedTotal = new Intl.NumberFormat('en-US', {
                                style: 'decimal'
                            }).format(totalBalanceInvoice);

                            // Set hasil ke elemen footer
                            $('#totalBalanceInvoice').text(formattedTotal);
                            updateBalance();
                        }
                    });

                    let tableP = $('#paymentsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ url('/transactions/AccountStatement/payments-data') }}',
                            data: function(d) {
                                d.year = $('#yearSelect').val(); // Ambil nilai tahun dari input
                                d.company_id = $('#company_id')
                                    .val(); // Ambil nilai nama perusahaan dari input
                            }
                        },
                        columns: [{
                                data: 'date',
                                className: 'text-center',
                                title: 'DATE'
                            },
                            {
                                data: 'payment_number',
                                className: 'text-center',
                                title: 'DESCRIPTION'
                            },
                            {
                                data: 'total',
                                className: 'text-center',
                                title: 'PAYMENT USD',
                                render: function(data) {
                                    return new Intl.NumberFormat('en-US', {
                                        style: 'decimal'
                                    }).format(data); // Format the balance value
                                }
                            },
                            {
                                data: 'balance',
                                className: 'text-center',
                                title: 'BALANCE',
                                render: function(data) {
                                    return '<b>' + new Intl.NumberFormat('en-US', {
                                        style: 'decimal'
                                    }).format(data) + '</b>'; // Format the balance value with bold font
                                }
                            }
                        ],
                        footerCallback: function(row, data, start, end, display) {
                            // Hitung total balance untuk payments
                            let totalBalancePayment = 0;
                            data.forEach(function(item) {
                                totalBalancePayment += parseFloat(item.total || 0);
                            });

                            // Format total balance dengan Intl.NumberFormat
                            let formattedTotal = new Intl.NumberFormat('en-US', {
                                style: 'decimal',
                                maximumFractionDigits: 0
                            }).format(totalBalancePayment);

                            // Set hasil ke elemen footer
                            $('#totalBalancePayment').text(formattedTotal);
                            updateBalance();
                        }
                    });

                    // Filter button
                    $('#filterBtn').click(function() {
                        let year = $('#yearSelect').val();
                        let company_id = $('#company_id').val();

                        if (!year || !company_id) {
                            $('#error-message').show();

                            setTimeout(function() {
                                $('#error-message').hide();
                            }, 3000);

                            return;
                        }

                        $('#error-message').hide();
                        table.ajax.reload(); // Reload data sesuai filter
                        tableP.ajax.reload(); // Reload data sesuai filter
                    });

                    // Reset button
                    $('#resetBtn').click(function() {
                        $('#yearSelect').val(null).trigger('change'); // Reset Select2
                        $('#company_id').val(null).trigger('change'); // Reset Select2

                        $('#companyStatement').html(
                            `PT PSN STATEMENT - <br>YEAR OF` // Hanya tampilkan tahun tanpa nama perusahaan
                        );

                        table.ajax.reload(); // Reload data tanpa filter
                        tableP.ajax.reload(); // Reload data tanpa filter
                    });
                });
            </script>
        @endsection
