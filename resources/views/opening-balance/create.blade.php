@extends('layouts.layout')
@section('title', 'Opening Balance')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Opening Balance</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Month</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p>{{ strtoupper(date('F Y')) }}</p>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select name="id_client" id="client_id"
                                                                class="form-control select2">
                                                                <option value="">Pilih Buyer</option>
                                                            </select>
                                                        </div>
                                                        <span class="error-message text-danger" id="id_client_error"
                                                            style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <p>Company Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                id="selectedClientCompanyName"
                                                                placeholder="Pilih Perusahaan Client" readonly>

                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-md"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#clientCompanyModal">
                                                                    <i data-feather="search"></i> Cari
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span class="error-message text-danger" id="id_client_company_error"
                                                            style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formBOP" class="mt-3 p-3 bg-light rounded shadow-sm" method="POST"
                                action="{{ route('opening-balance.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="no_inv" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="no_inv" name="no_inv"
                                        placeholder="Enter Invoice Number">
                                    <span class="error-message text-danger" id="no_inv_error" style="display: none;"></span>
                                </div>

                                <div class="mb-3">
                                    <label for="total" class="form-label">Payment</label>
                                    <input type="text" class="form-control" id="total" name="total"
                                        placeholder="Enter Payment">
                                    <span class="error-message text-danger" id="total_error" style="display: none;"></span>
                                </div>

                                <input type="hidden" id="month" name="month">
                                <input type="hidden" class="form-control" id="selectedClientId" name="id_client">
                                <input type="hidden" class="form-control" id="selectedClientCompanyId"
                                    name="id_client_company">

                                <div class="mt-7 d-flex justify-content-between">
                                    <a href="{{ route('opening-balance.index', ['dropdown_open' => true]) }}"
                                        class="btn btn-outline-primary me-3">Kembali</a>
                                    <div class="d-flex gap-2">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal Perusahaan Client --}}
    <div class="modal fade text-left" id="clientCompanyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Pilih Perusahaan Client</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table card-table table-vcenter text-nowrap" id="clientCompanyModalTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">PO BOX</th>
                                <th class="text-center">Telepon</th>
                                <th class="text-center">Fax</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- server side data --}}
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function() {
        //     $('#clientsModalTable').DataTable({
        //         autoWidth: false,
        //         processing: false,
        //         serverSide: true,
        //         ajax: "{{ route('clients.index') }}",
        //         columns: [{
        //                 data: null,
        //                 class: 'text-center',
        //                 render: function(data, type, row, meta) {
        //                     return meta.row + meta.settings._iDisplayStart + 1;
        //                 },
        //                 orderable: false,
        //                 searchable: false
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name',
        //             },
        //             {
        //                 data: 'company_name',
        //                 name: 'company_name',
        //                 class: 'text-center'
        //             },
        //             {
        //                 data: 'company_id',
        //                 name: 'company_id',
        //                 class: 'text-center'
        //             },
        //             {
        //                 data: 'address',
        //                 name: 'address',
        //             },
        //             {
        //                 data: null,
        //                 render: function(data, type, row) {
        //                     console.log(row);
        //                     return `<button class="btn btn-primary select-client" data-id="${row.id}" data-name="${row.name}" data-company="${row.company_name}" data-idcompany="${row.company_id}">Pilih</button>`;
        //                 },
        //                 class: 'text-center',
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ],
        //         language: {
        //             lengthMenu: "Tampilkan _MENU_ entri",
        //             info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        //             paginate: {
        //                 first: "Pertama",
        //                 last: "Terakhir",
        //                 next: "Selanjutnya",
        //                 previous: "Sebelumnya"
        //             },
        //             search: "Cari :",
        //             infoFiltered: "(disaring dari total _MAX_ entri)"
        //         },
        //         lengthMenu: [5, 10, 25, 50],
        //         pageLength: 10,
        //         drawCallback: function() {
        //             $('#clientsModalTable td:nth-child(2), #clientsModalTable th:nth-child(2)').css({
        //                 'max-width': '250px',
        //                 'white-space': 'normal',
        //                 'word-wrap': 'break-word'
        //             });
        //             $('#clientsModalTable td:nth-child(3), #clientsModalTable td:nth-child(4), #clientsModalTable td:nth-child(5)')
        //                 .css({
        //                     'max-width': '250px',
        //                     'white-space': 'normal',
        //                     'word-wrap': 'break-word'
        //                 });
        //         }
        //     });

        //     // Event listener untuk tombol "Pilih" di tabel client
        //     $('#clientsModalTable tbody').on('click', '.select-client', function() {
        //         var clientId = $(this).data('id');
        //         var clientName = $(this).data('name');
        //         var companyName = $(this).data('company');
        //         var companyID = $(this).data('idcompany');

        //         $('#selectedClientId').val(clientId);
        //         $('#selectedClientCompanyId').val(companyID);
        //         $('#selectedClientName').val(clientName);
        //         $('#selectedClientCompanyName').val(companyName);
        //         $('#clientsModal').modal('hide');

        //         $('#selectedClientId_error').text('').hide(); // Sembunyikan pesan error
        //         $('#selectedClientName').removeClass('is-invalid'); // Hapus border merah pada input
        //         $('.input-group').removeClass('has-error'); // Hapus border merah pada grup input
        //     });

        //     // Inisialisasi DataTable untuk #PITable
        //     $('#PITable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ route('getProformaInvoices') }}", // Route untuk mengambil data
        //             type: 'GET',
        //             data: function(d) {
        //                 var clientId = $('#selectedClientId').val();
        //                 d.id_client = clientId ? clientId : null;
        //             }
        //         },
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex',
        //                 orderable: false,
        //                 searchable: false,
        //                 className: 'text-center'
        //             },
        //             {
        //                 data: 'number',
        //                 name: 'number',
        //                 className: 'text-center'
        //             },
        //             {
        //                 data: 'code',
        //                 name: 'code',
        //                 className: 'text-center'
        //             },
        //             {
        //                 data: 'total_paid',
        //                 name: 'total_paid',
        //                 className: 'text-center',
        //                 render: function(data, type, row) {
        //                     return new Intl.NumberFormat('en-US', {
        //                         minimumFractionDigits: 0,
        //                         maximumFractionDigits: 0
        //                     }).format(data);
        //                 }
        //             },
        //             {
        //                 data: 'amount',
        //                 name: 'amount',
        //                 className: 'text-center',
        //                 render: function(data, type, row) {
        //                     return new Intl.NumberFormat('en-US', {
        //                         minimumFractionDigits: 0,
        //                         maximumFractionDigits: 0
        //                     }).format(data);
        //                 }
        //             },
        //             {
        //                 data: null,
        //                 orderable: false,
        //                 searchable: false,
        //                 className: 'text-center',
        //                 render: function(data, type, row) {
        //                     return `<button class="btn btn-primary btn-sm pilih-btn" 
    //     data-id="${row.id}" 
    //     data-number="${row.number}"
    //     data-paid="${row.total_paid}" 
    //     data-code="${row.code}" 
    //     data-amount="${row.amount}">
    //     Pilih
    //     </button>`;
        //                 }
        //             }
        //         ],
        //         language: {
        //             decimal: ".",
        //             thousands: ",",
        //             lengthMenu: "Tampilkan _MENU_ entri",
        //             zeroRecords: "Tidak ada data yang ditemukan",
        //             info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        //             infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
        //             infoFiltered: "(disaring dari _MAX_ total entri)",
        //             search: "Cari:",
        //             paginate: {
        //                 first: "Pertama",
        //                 last: "Terakhir",
        //                 next: "Selanjutnya",
        //                 previous: "Sebelumnya"
        //             },
        //             loadingRecords: "Sedang memuat...",
        //             processing: "Sedang memproses...",
        //             emptyTable: function() {
        //                 var clientSelected = $('#selectedClientId').val();
        //                 return clientSelected ?
        //                     "Buyer yang Anda pilih tidak memiliki tagihan" :
        //                     "Tolong pilih buyer terlebih dahulu";
        //             },
        //             aria: {
        //                 sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
        //                 sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
        //             },
        //             select: {
        //                 rows: {
        //                     _: "%d baris terpilih",
        //                     1: "1 baris terpilih"
        //                 }
        //             }
        //         },
        //         responsive: true,
        //         autoWidth: false,
        //         order: [
        //             [2, 'desc']
        //         ],
        //         pageLength: 10
        //     });

        //     // Mendapatkan bulan dan tahun saat ini
        //     var currentDate = new Date();
        //     var options = {
        //         year: 'numeric',
        //         month: 'long'
        //     };
        //     var monthYear = currentDate.toLocaleDateString('id-ID', options).toUpperCase();

        //     // Menetapkan nilai input #month
        //     $('#month').val(monthYear);
        // });

        // Initialize Select2 for client
        $(document).ready(function() {
            $('#client_id').select2({
                placeholder: "Pilih Client",
                width: '100%',
                ajax: {
                    url: '{{ route('proforma.clients.select2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Search query
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                }
            });
        });

        $(document).ready(function() {
            // Event listener untuk select client
            $('#client_id').on('change', function() {
                var clientId = $(this).val();
                var clientName = $('#client_id option:selected').text();

                $('#selectedClientId').val(clientId);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyId').val('');
                $('#selectedClientCompanyName').val('');

                // Memuat data consignee berdasarkan ID client yang dipilih
                loadClientCompanies(clientId);
            });

            var clientCompanyTable = $('#clientCompanyModalTable').DataTable({
                autoWidth: false,
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('clientCompanies.byClient', ['clientId' => 0]) }}", // Initial empty clientId
                    dataSrc: function(json) {
                        if (json.data.length === 0) {
                            if ($('#selectedClientId').val() === '' || $('#selectedClientId').val() ===
                                '0') {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Harap pilih client terlebih dahulu";
                            } else {
                                clientCompanyTable.settings()[0].oLanguage.sEmptyTable =
                                    "Tidak ada client company untuk client ini";
                            }
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'PO_BOX',
                        name: 'PO_BOX',
                        class: 'text-center'
                    },
                    {
                        data: 'tel',
                        name: 'tel',
                        class: 'text-center'
                    },
                    {
                        data: 'fax',
                        name: 'fax',
                        class: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="text-center">
                                        <button class="btn btn-primary select-client-company" data-id="${row.id}" data-name="${row.company_name}">Pilih</button>
                                    </div>`;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    search: "Cari :",
                    infoFiltered: "(disaring dari total _MAX_ entri)",
                    emptyTable: "Harap pilih client terlebih dahulu"
                },
                lengthMenu: [5, 10, 25, 50],
                pageLength: 10,
                drawCallback: function() {
                    $('#clientCompanyModalTable td:nth-child(2), #clientCompanyModalTable th:nth-child(2)')
                        .css({
                            'max-width': '200px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                    $('#clientCompanyModalTable td:nth-child(3), #clientCompanyModalTable th:nth-child(3)')
                        .css({
                            'max-width': '250px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word'
                        });
                }
            });

            window.loadClientCompanies = function(clientId) {
                if (!clientId || clientId === '0') {
                    clientCompanyTable.ajax.url(
                        "{{ route('clientCompanies.byClient', ['clientId' => ':clientId']) }}".replace(
                            ':clientId', clientId)).load();
                    return;
                }

                clientCompanyTable.ajax.url(
                    "{{ route('clientCompanies.byClient', ['clientId' => ':clientId']) }}".replace(
                        ':clientId', clientId)).load();
            };


            // Event listener for opening the client company modal
            $('#openClientCompanyModal').on('click', function() {
                var clientId = $('#selectedClientId').val();

                if (!clientId) {
                    clientCompanyTable.ajax.url(
                        "{{ route('clientCompanies.byClient', ['clientId' => 0]) }}").load();
                }

                $('#clientCompanyModal').modal('show');
            });

            // Event listener for selecting a client company from the modal
            $('#clientCompanyModalTable tbody').on('click', '.select-client-company', function() {
                var clientCompanyId = $(this).data('id');
                var clientCompanyName = $(this).data('name');

                $('#selectedClientCompanyId').val(clientCompanyId);
                $('#selectedClientCompanyName').val(clientCompanyName);
                $('#clientCompanyModal').modal('hide');
            });

            $('#PITable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getProformaInvoices') }}", // Route untuk mengambil data
                    type: 'GET',
                    data: function(d) {
                        var clientId = $('#selectedClientId').val();
                        d.id_client = clientId ? clientId : null;
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'number',
                        name: 'number',
                        className: 'text-center'
                    },
                    {
                        data: 'code',
                        name: 'code',
                        className: 'text-center'
                    },
                    {
                        data: 'total_paid',
                        name: 'total_paid',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `<button class="btn btn-primary btn-sm pilih-btn" 
            data-id="${row.id}" 
            data-number="${row.number}"
            data-paid="${row.total_paid}" 
            data-code="${row.code}" 
            data-amount="${row.amount}">
            Pilih
            </button>`;
                        }
                    }
                ],
                language: {
                    decimal: ".",
                    thousands: ",",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    loadingRecords: "Sedang memuat...",
                    processing: "Sedang memproses...",
                    emptyTable: function() {
                        var clientSelected = $('#selectedClientId').val();
                        return clientSelected ?
                            "Buyer yang Anda pilih tidak memiliki tagihan" :
                            "Tolong pilih buyer terlebih dahulu";
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
                        sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
                    },
                    select: {
                        rows: {
                            _: "%d baris terpilih",
                            1: "1 baris terpilih"
                        }
                    }
                },
                responsive: true,
                autoWidth: false,
                order: [
                    [2, 'desc']
                ],
                pageLength: 10
            });

            // Mendapatkan bulan dan tahun saat ini
            var currentDate = new Date();
            var options = {
                year: 'numeric',
                month: 'long'
            };

            // Mendapatkan bulan dan tahun dalam format 'long' (misalnya "Januari 2024")
            var monthYear = currentDate.toLocaleDateString('id-ID', options);

            // Mengonversi bulan dalam bahasa Indonesia menjadi bahasa Inggris
            var monthsIndoToEng = {
                "Januari": "January",
                "Februari": "February",
                "Maret": "March",
                "April": "April",
                "Mei": "May",
                "Juni": "June",
                "Juli": "July",
                "Agustus": "August",
                "September": "September",
                "Oktober": "October",
                "November": "November",
                "Desember": "December"
            };

            // Mengambil nama bulan dan mengonversinya
            var monthInEnglish = monthsIndoToEng[monthYear.split(' ')[0]];

            // Mengonversi bulan dan tahun ke format yang dapat diterima oleh Carbon
            var convertedMonthYear = monthInEnglish + ' ' + monthYear.split(' ')[1];

            // Menetapkan nilai input #month
            $('#month').val(convertedMonthYear);
        });

        $(document).ready(function() {
            // Format the 'total' input value with commas as the user types
            $('#total').on('input', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
                $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g,
                    ',')); // Add commas as thousands separator
            });

            // Optional: When submitting the form, remove commas
            $('#formBOP').on('submit', function() {
                var paymentValue = $('#total').val();
                var formattedValue = paymentValue.replace(/,/g, ''); // Remove commas
                $('#total').val(formattedValue); // Set the raw value without commas
            });
        });

        $(document).ready(function() {
            $('#formBOP').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                let formData = new FormData(this);

                // Clear previous error messages
                $('.error-message').hide().text('');

                // Variable to track if there are any errors
                let hasError = false;

                // Send the form data via AJAX
                $.ajax({
                    url: "{{ route('opening-balance.store') }}", // Route to handle the form submission
                    method: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Don't set content type
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(data) {
                        if (data.success) {
                            // Handle success (e.g., redirect or show success message)
                            window.location.href =
                                "{{ route('opening-balance.index') }}"; // Redirect on success
                        }
                    },
                    error: function(xhr) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(field, messages) {
                                let errorElement = $('#' + field + '_error');
                                if (errorElement.length) {
                                    errorElement.show().text(messages[
                                        0]); // Display the first error message
                                    hasError = true; // Set error flag to true
                                }
                            });
                        }

                        // If no errors were found, proceed with form submission
                        if (!hasError) {
                            // Proceed with the AJAX submission (optional)
                            $.ajax({
                                url: "{{ route('opening-balance.store') }}", // Your form submission route
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    // Handle successful submission (e.g., show success message or redirect)
                                    window.location.href =
                                        "{{ route('opening-balance.index') }}"; // Redirect on success
                                },
                                error: function(xhr) {
                                    // Cek apakah response memiliki success: false
                                    var response = xhr.responseJSON;

                                    if (response && response.success === false) {
                                        // Menampilkan pesan error dari response menggunakan SweetAlert
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.message
                                        });
                                    } else {
                                        // Menangani error lainnya (jika ada)
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Something went wrong!',
                                            text: response.message
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
