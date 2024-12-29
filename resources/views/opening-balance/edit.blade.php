@extends('layouts.layout')
@section('title', 'Edit Opening Balance')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- Form Section -->
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                            <h3 class="card-title">Form Edit Opening Balance</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: '{{ session('success') }}', // Pesan sukses yang disertakan di session
                                        showConfirmButton: true,
                                    });
                                </script>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-7">
                                            <!-- Display Month (readonly) -->
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

                                            <!-- Display Buyer Name (readonly) -->
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Buyer Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <input type="text" class="form-control" id="selectedClientName"
                                                        value="{{ $paymentDetail->client->name }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Display Company Name (readonly) -->
                                            <div class="row mt-2">
                                                <div class="col-4">
                                                    <p>Company Name</p>
                                                </div>
                                                <div class="col-1 text-center">
                                                    <span>:</span>
                                                </div>
                                                <div class="col-7">
                                                    <input type="text" class="form-control"
                                                        id="selectedClientCompanyName"
                                                        value="{{ $paymentDetail->clientCompany ? $paymentDetail->clientCompany->company_name : 'N/A' }}"
                                                        readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form for Editing Description and Payment -->
                            <form id="formBOP" method="POST" action="{{ route('opening-balance.update', $hashId) }}"
                                class="mt-3 p-3 bg-light rounded shadow-sm">
                                @csrf
                                @method('PUT')

                                <!-- Editable Description Field -->
                                <div class="mb-3">
                                    <label for="no_inv" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="no_inv" name="no_inv"
                                        value="{{ old('no_inv', $paymentDetail->payment_number) }}"
                                        placeholder="Enter Invoice Number">
                                    <span class="error-message text-danger" id="no_inv_error" style="display: none;"></span>
                                </div>

                                <!-- Editable Payment Field -->
                                <div class="mb-3">
                                    <label for="total" class="form-label">Payment</label>
                                    <!-- Change input type to text to allow formatting with commas -->
                                    <input type="text" class="form-control" id="total" name="total"
                                        value="{{ old('total', number_format($paymentDetail->total, 0, ',', '.')) }}"
                                        placeholder="Enter Payment">
                                    <span class="error-message text-danger" id="total_error" style="display: none;"></span>
                                </div>

                                <!-- Hidden Fields for Month and Client Data -->
                                <input type="hidden" id="month" name="month" value="{{ strtoupper(date('F Y')) }}">
                                <input type="hidden" class="form-control" id="selectedClientId" name="id_client"
                                    value="{{ $paymentDetail->id_client }}">
                                <input type="hidden" class="form-control" id="selectedClientCompanyId"
                                    name="id_client_company" value="{{ $paymentDetail->id_client_company }}">

                                <!-- Submit and Reset Buttons -->
                                <div class="text-end">
                                    {{-- <button type="reset" class="btn btn-secondary">Reset</button> --}}
                                    <a href="{{ route('opening-balance.index') }}" class="btn btn-outline-primary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal Handling (Client selection) -->
    <script>
        $(document).ready(function() {
            // Handle client selection in the modal
            $('#clientsModalTable tbody').on('click', '.select-client', function() {
                var clientId = $(this).data('id');
                var clientName = $(this).data('name');
                var companyName = $(this).data('company');
                var companyID = $(this).data('idcompany');

                // Update the form with selected client data
                $('#selectedClientId').val(clientId);
                $('#selectedClientCompanyId').val(companyID);
                $('#selectedClientName').val(clientName);
                $('#selectedClientCompanyName').val(companyName);

                // Close the modal
                $('#clientsModal').modal('hide');

                // Clear any error messages
                $('#selectedClientId_error').text('').hide();
                $('#selectedClientName').removeClass('is-invalid');
                $('.input-group').removeClass('has-error');
            });

            // Format the 'total' input value with commas as the user types
            $('#total').on('input', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
                $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g,
                    '.')); // Add commas as thousands separator
            });

            // Optional: When submitting the form, remove commas
            $('form').on('submit', function() {
                var paymentValue = $('#total').val();
                var formattedValue = paymentValue.replace(/\./g, ''); // Remove commas
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
                    url: "{{ route('opening-balance.update', $hashId) }}", // Route to handle the form submission
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
                            window.location.reload();
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
                                url: "{{ route('opening-balance.update', $hashId) }}", // Your form submission route
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
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
