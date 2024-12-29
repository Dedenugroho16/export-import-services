@extends('layouts.layout')
@section('title', 'Payment Details')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Payment Details</h3>
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
                                                    <p>DATE
                                                    <p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p>{{ strtoupper(date('F d, Y')) }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>PAYMENT NUMBER</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p id="payment-number-display">{{ $paymentDetails->payment_number }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>BUYER NAME</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <p>{{ $paymentDetails->client->name }}</p>
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
                                                    <p>{{ $paymentDetails->clientCompany->company_name}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="formTransaction" action="{{ route('payments.update') }}">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <span class="error-message" id="pi_error"
                                            style="color: red; display: none;"></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <table class="table table-striped table-hover" id="paymentDetailTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">PI. NUMBER</th>
                                                    <th class="text-center">CODE</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">PAID</th>
                                                    <th class="text-center">TRANSFERED</th>
                                                    <th class="text-center">BILL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-end" colspan="5">
                                                        <label for="total" class="mr-2">AMOUNT OF PAYMENT:</label>
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

                            <form id="formPaymentDetails" class="mt-2" method="POST"
                                action="{{ route('payment-details.update', $paymentDetails->id) }}">
                                @csrf
                                <input type="hidden" name="date" id="date" value="{{ $paymentDetails->date }}">
                                <input type="hidden" id="id_bill_of_payment" name="id_bill_of_payment"
                                    value="{{ $paymentDetails->billOfPayment->id }}">
                                <input type="hidden" id="payment_number" name="payment_number"
                                    value="{{ $paymentDetails->payment_number }}">
                                <input type="hidden" id="selectedClientId" name="id_client"
                                    value="{{ $paymentDetails->client->id }}">
                                <input type="hidden" id="total" name="total">
                            </form>

                            <!-- Tombol Submit -->
                            <div class="text-end mt-6">
                                <a href="{{ route('bill-of-payments.details', $hashedBOPId) }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="button" id="submitButton" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="clientsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Pilih Client</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table card-table table-vcenter text-nowrap" id="clientsModalTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Nama Perusahaan</th>
                                <th class="text-center">Alamat</th>
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
        $(document).ready(function() {
            function loadTransaction(idBillOfPayment, idPaymentDetail) {
                $.ajax({
                    url: `/get-transactions/${idBillOfPayment}/${idPaymentDetail}`,
                    method: 'GET',
                    success: function(response) {
                        // Kosongkan tbody untuk data yang baru di-load
                        $('#paymentDetailTable tbody').empty();

                        if (response.length > 0) {
                            response.forEach(function(data) {
                                let total = Number(data.total);
                                let transferedValue = parseFloat(data.descriptionTransfered ||
                                    0);
                                let formattedTransfered = transferedValue.toLocaleString(
                                    'en-US');
                                var newRow = `
                                                <tr>
                                                    <td class="text-center" style="display: none;">
                                                        <input class="id-proforma" type="hidden" name="transactions[${data.id}][id]" value="${data.id}">
                                                    </td>
                                                    <td class="text-center" style="display: none;">
                                                        <input type="hidden" id="id_payment_detail" name="transactions[${data.id}][id_payment_detail]">
                                                    </td>
                                                    <td class="text-center">${data.number}</td>
                                                    <td class="text-center">${data.code}</td>
                                                    <td class="text-center">
                                                        <input type="text" name="transactions[${data.id}][description]" 
                                                            class="form-control description-input"
                                                            value="${data.descriptionPayments || ''}">
                                                    </td>
                                                    <td class="text-center amount">${total?.toLocaleString('en-US') || '0'}</td>
                                                    <td class="text-center paid">${data.paid?.toLocaleString('en-US') || '0'}</td>
                                                    <td class="text-center" style="width:150px;">
                                                        <input type="text" class="form-control transfered-input" placeholder="Uang ditransfer" value="${formattedTransfered}">
                                                        <input type="hidden" name="transactions[${data.id}][transfered]" class="form-control transfered" value="${transferedValue}">
                                                    </td>
                                                    <td class="text-center pi-bill">${(data.total - data.paid)?.toLocaleString('en-US') || '0'}</td>
                                                </tr>
                                            `;
                                $('#paymentDetailTable tbody').append(newRow);
                            });
                        } else {
                            $('#paymentDetailTable tbody').append(`
                        <tr>
                            <td colspan="6" class="text-center" id="nullDetailTransaction">Tidak ada detail transaksi yang tersedia.</td>
                        </tr>
                    `);
                        }
                        updateAmounts();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching detail transactions:', error);
                    }
                });
            }

            $('#paymentDetailTable tbody').on('input', '.transfered-input', function() {
                var row = $(this).closest('tr');
                var paymentInput = row.find('.transfered-input');

                var payment = parseFloat(paymentInput.val().replace(/,/g, '')) || 0;
                var piBill = parseFloat(row.find('.pi-bill').text().replace(/,/g, '')) || 0;
                var formattedPayment = payment.toLocaleString('en-US');
                row.find('.transfered-input').val(formattedPayment); // Update tampilan input
                row.find('.transfered').val(payment); // Update nilai hidden input

                if (payment > piBill) {
                    $('#submitButton').prop('disabled', true); // Disable tombol submit
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Transfer Tidak Valid',
                        text: 'Nilai transfer tidak boleh lebih besar dari jumlah yang harus dibayar.',
                    });
                } else {
                    $('#submitButton').prop('disabled', false); // Aktifkan tombol jika valid
                }

                updateAmounts(); // Perbarui total saat input berubah
            });

            // Pastikan idBillOfPayment tersedia untuk memuat data dari database
            var idBillOfPayment = "{{ $paymentDetails->billOfPayment->id }}";
            var idPaymentDetail = "{{ $paymentDetails->id }}";
            if (idBillOfPayment && idPaymentDetail) {
                loadTransaction(idBillOfPayment, idPaymentDetail);
            }

            function updateAmounts() {
                var totalPayment = 0;

                // Iterasi setiap baris untuk mendapatkan nilai total transfered
                $('#paymentDetailTable tbody tr').each(function() {
                    var row = $(this);

                    // Ambil nilai dari transfered-input
                    var paymentInput = row.find('.transfered-input');
                    var payment = parseFloat(paymentInput.val().replace(/,/g, '')) || 0;

                    // Format nilai untuk tampilan
                    var formattedPayment = payment.toLocaleString('en-US');

                    // Perbarui nilai transfered-input dan hidden transfered
                    paymentInput.val(formattedPayment);
                    row.find('.transfered').val(payment);

                    // Tambahkan ke total
                    totalPayment += payment;
                });

                // Format hasil total dan update ke footer
                var formattedTotalPayment = totalPayment.toLocaleString('en-US');
                $('.total-display').val(formattedTotalPayment); // Untuk tampilan
                $('#total').val(totalPayment); // Nilai asli
            }
        });

        $(document).ready(function() {
            function validateTransactionForm() {
                var isValid = true;
                var errorMessage = 'Semua kolom wajib diisi!';

                // Reset pesan error
                $('#pi_error').text('').hide();

                // Iterasi setiap baris dalam tbody
                $('#paymentDetailTable tbody tr').each(function() {
                    var row = $(this);
                    var inputs = row.find(
                        'input:not([type="hidden"])'
                    ); // Hanya memvalidasi input yang terlihat (bukan hidden)

                    inputs.each(function() {
                        var input = $(this);
                        if (input.val().trim() === '') {
                            isValid = false;
                            input.addClass(
                                'is-invalid'); // Tambahkan kelas untuk menandai input tidak valid
                        } else {
                            input.removeClass('is-invalid'); // Hapus tanda jika valid
                        }
                    });
                });

                if (!isValid) {
                    $('#pi_error').text(errorMessage).show(); // Tampilkan pesan error
                }

                return isValid; // Kembalikan status validasi
            }

            $('#submitButton').on('click', function() {
                var formPaymentDetails = $('#formPaymentDetails');
                var formDataPaymentDetails = formPaymentDetails.serialize(); // Serialize form data

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
                        text: 'Mohon lengkapi data Payment Details!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan proses jika form detail transaksi tidak valid
                }

                // Submit formPaymentDetails via AJAX
                $.ajax({
                    url: formPaymentDetails.attr(
                        'action'), // The action URL from the formPaymentDetails
                    method: 'POST',
                    data: formDataPaymentDetails,
                    success: function(response) {
                        if (response.success) {
                            var idPD = response.id_pd;

                            var formTransaction = $('#formTransaction');
                            $('#paymentDetailTable tbody tr').each(function() {
                                // Cari input yang memiliki name id_payment_detail
                                $(this).find('input[name^="transactions"]').each(
                                    function() {
                                        if ($(this).attr('name').includes(
                                                'id_payment_detail')) {
                                            $(this).val(
                                                idPD
                                            ); // Pastikan idPD dari respons di-set
                                        }
                                    });
                            });

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
                                            text: response
                                                .message, // Menampilkan pesan dari server
                                        }).then(function() {
                                            window.location.href =
                                                '{{ route('bill-of-payments.details', $hashedBOPId) }}'; // Redirect ke halaman yang diinginkan
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
                                        title: 'Gagal Menyimpan Data!',
                                        text: response.message ||
                                            'Terjadi kesalahan validasi data. Periksa input Anda dan coba lagi.',
                                    });
                                }
                            });
                        } else {
                            $(this).prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menyimpan Data!',
                                text: response.message ||
                                    'Terjadi kesalahan validasi data. Periksa input Anda dan coba lagi.',
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
