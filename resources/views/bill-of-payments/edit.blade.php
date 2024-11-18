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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Month</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p>{{ $billOfPayment->month }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>No. Inv</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p id="no-inv-display">{{ $billOfPayment->no_inv }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p id="no-inv-display">{{ $billOfPayment->client->name }}</p>
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
                                                    <p id="no-inv-display">{{ $billOfPayment->client->company_name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formTransaction" action="{{ route('proforma-bop.update') }}">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="btn-group mb-1">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#PIModal">
                                                <i data-feather="search"></i> Cari proforma invoices
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="error-message" id="pi_error"
                                            style="color: red; display: none;"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <table class="table table-striped table-hover" id="billOfPaymentTable">
                                            <thead>
                                                <tr>
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
                                            <tfoot>
                                                <tr>
                                                    <td class="text-end" colspan="5">
                                                        <label for="total" class="mr-2">AMOUNT OF BILL:</label>
                                                    </td>
                                                    <td class="text-center" style="width: 120px;">
                                                        <div
                                                            class="form-group d-flex align-items-center justify-content-center">
                                                            <input type="text" step="0.01"
                                                                class="form-control total-display" readonly>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </form>

                            <form id="formBOP" class="mt-2" method="POST"
                                action="{{ route('bill-of-payment.update', $billOfPayment->id) }}">
                                @csrf
                                @method('PATCH') <!-- Menentukan metode update -->
                                <input type="hidden" id="month" name="month" value="{{ $billOfPayment->month }}">
                                <input type="hidden" id="no_inv" name="no_inv" value="{{ $billOfPayment->no_inv }}">
                                <input type="hidden" id="selectedClientId" name="id_client"
                                    value="{{ $billOfPayment->client->id }}">
                                <input type="hidden" id="total" name="total">
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payment.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="PIModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header border-bottom bg-transparent">
                    <h4 class="modal-title">Proforma Invoices</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="PITable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">PI. NUMBER</th>
                                            <th class="text-center">CODE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                        aria-label="Close">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function totalBill() {
                var totalPaid = 0;
                var totalBill = 0;

                // Iterasi setiap baris untuk mendapatkan nilai total
                $('#billOfPaymentTable tbody tr').each(function() {
                    var paid = parseFloat($(this).find('.paid').val()) ||
                        0; // Nilai asli dari input tersembunyi
                    var bill = parseFloat($(this).find('.pi-bill').text().replace(/,/g, '')) || 0;

                    totalPaid += paid;
                    totalBill += bill;
                });

                // Hitung grandTotal
                var grandTotal = totalBill - totalPaid;

                // Format grandTotal dengan toLocaleString dan tampilkan di .total-display
                var formattedGrandTotal = grandTotal.toLocaleString('en-US');

                // Update nilai total di elemen input total-display
                $('.total-display').val(formattedGrandTotal);
                $('#total').val(grandTotal); // Update hidden field dengan nilai tanpa format
            }

            function addDynamicEventListeners() {
                // Event listener untuk perubahan pada .paid-input
                $('#billOfPaymentTable tbody').on('input', '.paid-input', function() {
                    var row = $(this).closest('tr'); // Mendapatkan baris tempat input berada
                    var input = $(this);

                    // Ambil nilai dari .paid-input dan hapus format (koma) jika ada
                    var paidValue = parseFloat(input.val().replace(/,/g, '')) || 0;

                    // Update input tersembunyi .paid untuk penyimpanan nilai asli tanpa format
                    row.find('.paid').val(paidValue);

                    // Format kembali nilai di .paid-input agar menampilkan dengan format toLocaleString
                    input.val(paidValue.toLocaleString('en-US'));

                    // Perbarui total bill setelah setiap perubahan
                    totalBill();
                });
            }

            function loadTransaction(idBillOfPayment) {
                $.ajax({
                    url: `/get-transactions/${idBillOfPayment}`,
                    method: 'GET',
                    success: function(response) {
                        // Kosongkan tbody untuk data yang baru di-load
                        $('#billOfPaymentTable tbody').empty();

                        if (response.length > 0) {
                            response.forEach(function(data) {
                                var paid = data.paid || 0;
                                var intPaid = Math.floor(paid);
                                var formattedPaid = intPaid.toLocaleString('en-US');

                                var total = data.total || 0;
                                var intTotal = Math.floor(total);
                                var formattedTotal = intTotal.toLocaleString('en-US');

                                var newRow = `
                        <tr>
                            <td class="text-center" style="display: none;">
                                <input type="hidden" name="transactions[${data.id}][id]" value="${data.id}">
                            </td>
                            <td class="text-center" style="display: none;">
                                <input type="hidden" id="id_bill" name="transactions[${data.id}][id_bill]">
                            </td>
                            <td class="text-center">${data.number}</td>
                            <td class="text-center">${data.code}</td>
                            <td class="text-center">
                                <input type="text" name="transactions[${data.id}][description]" class="form-control description-input" value="${data.description}">
                            </td>
                            <td class="text-center amount">${formattedTotal}</td>
                            <td class="text-center">
                                <input type="text" class="form-control paid-input" style="width: 120px;" value="${formattedPaid}"> <!-- Langsung menggunakan formattedPaid -->
                                <input type="hidden" name="transactions[${data.id}][paid]" class="form-control paid" value="${paid}">
                            </td>
                            <td class="text-center pi-bill">${formattedTotal}</td>
                        </tr>
                    `;
                                $('#billOfPaymentTable tbody').append(newRow);
                            });

                            // Panggil addDynamicEventListeners setelah elemen baru ditambahkan
                            addDynamicEventListeners();
                        } else {
                            $('#billOfPaymentTable tbody').append(`
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada detail transaksi yang tersedia.</td>
                    </tr>
                `);
                        }

                        // Update total setelah data dimuat
                        totalBill();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching detail transactions:', error);
                    }
                });
            }

            // Pastikan idBillOfPayment tersedia untuk memuat data dari database
            var idBillOfPayment = "{{ $billOfPayment->id }}";
            if (idBillOfPayment) {
                loadTransaction(idBillOfPayment);
            }
        });

        $(document).ready(function() {
            function validateTransactionForm() {
                var isValid = true;

                // Cek apakah ada input selain yang memiliki id="id_transaction"
                var totalInputs = $('#billOfPaymentTable tbody input').length; // Total input dalam form
                var otherInputs = $('#billOfPaymentTable tbody input').not('#id_bill')
                    .length;

                if (otherInputs === 0) {
                    isValid = false; // Jika tidak ada input selain id_transaction, form tidak valid
                    $('#pi_error').text('Data Proforma Invoice harus diisi!').show();
                }

                return isValid; // Kembalikan status validasi
            }

            $('#submitButton').on('click', function() {
                var formBOP = $('#formBOP');
                var formDataBOP = formBOP.serialize(); // Serialize form data

                // Disable the submit button to prevent multiple submissions
                $(this).prop('disabled', true);

                var selectedClientId = $('#selectedClientId').val();
                if (!selectedClientId) {
                    $('#selectedClientId_error').text('Data Buyer harus diisi').show();
                    $('#selectedClientName').addClass('is-invalid'); // Tambah border merah pada input
                    $('.input-group').addClass('has-error'); // Tambah border merah pada grup input
                }

                var isValidDetailTransaction = validateTransactionForm();

                if (!isValidDetailTransaction) {
                    $('#submitButton').prop('disabled', false);
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: 'Mohon lengkapi data Bill of Payment!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan proses jika form detail transaksi tidak valid
                }

                // Submit formBOP via AJAX
                $.ajax({
                    url: formBOP.attr('action'), // The action URL from the formBOP
                    method: 'POST',
                    data: formDataBOP,
                    success: function(response) {
                        if (response.success) {
                            // Capture the returned id_bill from the response
                            var idBill = response.id_bill;

                            // Now process formTransaction by appending the rows with the id_bill
                            var formTransaction = $('#formTransaction');
                            $('#billOfPaymentTable tbody tr').each(function() {
                                // For each row in the table, set the id_bill for the hidden input
                                $(this).find('input[name^="transactions"]').each(
                                    function() {
                                        if ($(this).attr('name').includes(
                                                'id_bill')) {
                                            $(this).val(
                                                idBill); // Set the value of id_bill
                                        }
                                    });
                            });

                            // Submit formTransaction via AJAX after setting id_bill
                            var formDataTransaction = formTransaction
                                .serialize(); // Serialize form data
                            $.ajax({
                                url: formTransaction.attr(
                                    'action'), // The action URL from formTransaction
                                method: 'POST',
                                data: formDataTransaction,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: 'Bill of Payment telah diperbarui!', // Menampilkan pesan dari server
                                        }).then(function() {
                                            window.location.href =
                                                '{{ route('bill-of-payment.index') }}'; // Redirect ke halaman yang diinginkan
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal Menyimpan Transaksi!',
                                            text: response.message ||
                                                'Terjadi kesalahan saat menyimpan transaksi.',
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan!',
                                        text: 'Gagal mengirimkan Proforma Invoice.',
                                    });
                                }
                            });

                        } else {
                            $(this).prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal membuat Bill of Payment!',
                                text: response.message ||
                                    'Terjadi kesalahan saat membuat Bill of Payment.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Periksa kembali inputan Anda';

                        // Periksa apakah server mengembalikan error dalam format JSON
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            // Jika format bukan JSON, gunakan responseText
                            errorMessage = xhr.responseText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: errorMessage,
                        });
                    },
                    complete: function() {
                        // Aktifkan kembali tombol setelah selesai (sukses/gagal)
                        $('#submitButton').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
