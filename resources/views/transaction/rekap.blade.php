@extends('layouts.layout')
@section('title', 'Rekap Sales')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="mb-4 mt-4 d-flex justify-content-between">
            <!-- Filter by Stuffing Date -->
            <form class="d-flex align-items-center" method="GET" id="filterForm">
                <div class="input-group">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" required>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" required>
                    
                    <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
                    <a href="{{ route('transactions.rekap') }}" class="btn btn-secondary me-2">Reset</a>
                    
                </div>
            </form>
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                </svg>
                Ekspor/Download
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" id="exporPdf" target="_blank">Expor PDF</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" id="downloadPdf">Download PDF</a>
                </li>
            </ul>
        </div>
        <div id="error-message" class="alert alert-important alert-danger alert-dismissible" role="alert" style="display: none;">
            <div class="d-flex">
                <div><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg></div>
                <div>Tolong pilih tanggal terlebih dahulu.</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
        </div>        
        <!-- Rekap Section -->
        <div class="card mb-5">
            <div class="card-body">
                <div class="text-center mb-5" style="font-family: 'Times New Roman', Times, serif">
                    <h2 class="mb-1"><strong>PT.PRINGGONDANI SETIA NUSANTARA<br>REKAP SALES</strong></h2>
                    <p style="font-size: 15px">
                        PERIODE STUFFING 
                        <span id="startPeriod">{{ request('start_date') ? request('start_date') : '-' }}</span>
                        s/d 
                        <span id="endPeriod">{{ request('end_date') ? request('end_date') : '-' }}</span>
                    </p>
                </div>                               
                <div id="rekap-table" class="table-responsive">
                    <table class="table table-vcenter table-nowrap" id="rekapTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Stuffing Date</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">BL Number</th>
                                <th class="text-center">Container Number</th>
                                <th class="text-center">Seal Number</th>
                                <th class="text-center">Net Weight</th>
                                <th class="text-center">Gross Weight</th>
                                <th class="text-center">Ocean Freight</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="noDataRow">
                                <td colspan="12" class="text-center">Silakan lakukan filter berdasarkan stuffing date</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-center">Total</th>
                                <th id="totalNetWeight">-</th>
                                <th id="totalGrossWeight">-</th>
                                <th id="totalFreightCost">-</th>
                                <th id="totalAmount">-</th>
                                <th id="total">-</th>
                            </tr>
                        </tfoot>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Script -->
<script>
    $(document).ready(function () {
        let table = $('#rekapTable').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            searching: false,
            info: false,
            ajax: {
                url: "{{ route('transactions.rekap') }}",
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                },
                dataSrc: function (json) {
                    // Update footer dengan total dari server jika data ditemukan
                    if (json.data.length > 0) {
                        $('#totalNetWeight').text(json.totalNetWeight);
                        $('#totalGrossWeight').text(json.totalGrossWeight);
                        $('#totalFreightCost').text(json.totalFreightCost);
                        $('#totalAmount').text(json.totalAmount);
                        $('#total').text(json.total);
                    } else {
                        $('#totalNetWeight, #totalGrossWeight, #totalFreightCost, #totalAmount, #total').text('-');
                    }
                    return json.data;
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'stuffing_date' },
                { data: 'code' },
                { data: 'number' },
                { data: 'bl_number' },
                { data: 'container_number' },
                { data: 'seal_number' },
                { data: 'net_weight' },
                { data: 'gross_weight' },
                { data: 'freight_cost' },
                { data: 'total_price_amount' },
                { data: 'total' }
            ],
            language: {
                emptyTable: function () {
                    let startDate = $('#start_date').val();
                    let endDate = $('#end_date').val();
                    return startDate && endDate ? "Tidak ada transaksi untuk periode yang dipilih." : "Silakan lakukan filter berdasarkan stuffing date.";
                }
            },
            drawCallback: function () {
                // Update periode stuffing di header
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                $('#startPeriod').text(startDate || '-');
                $('#endPeriod').text(endDate || '-');
            }
        });

        // Event listener untuk tombol filter
        $('#filterBtn').click(function () {
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();

            if (!startDate || !endDate) {
                $('#error-message').show();

                setTimeout(function() {
                    $('#error-message').hide();
                }, 3000);

                return;
            }

            $('#error-message').hide();

            table.ajax.reload();
        });

        $('#resetBtn').click(function () {
            $('#start_date').val('');
            $('#end_date').val('');
            table.ajax.reload();
        });

        // Event listener untuk stream PDF
        $('#exporPdf').click(function (e) {
            e.preventDefault();

            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();

            if (!startDate || !endDate) {
                $('#error-message').show();

                setTimeout(function() {
                    $('#error-message').hide();
                }, 3000);

                return;
            }

            $('#error-message').hide();

            let url = `{{ route('transactions.rekapPdf') }}?start_date=${startDate}&end_date=${endDate}`;
            window.open(url, '_blank');
        });

        // Event listener untuk download PDF
        $('#downloadPdf').click(function (e) {
            e.preventDefault();

            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();

            if (!startDate || !endDate) {
                $('#error-message').show();

                setTimeout(function() {
                    $('#error-message').hide();
                }, 3000);

                return;
            }

            $('#error-message').hide();

            window.location.href = `{{ route('transactions.downloadRekapPdf') }}?start_date=${startDate}&end_date=${endDate}`;
        });
    });
</script>
@endsection