@extends('layouts.layout')
@section('title', 'Dashboard')
@section('content')
<div class="page-body">
  <div class="container">
    <div class="row">
      <!-- Card 1 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title">Clients</h3>
              <a href="{{ route('proforma.index') }}">
                <span class="avatar" style="border-radius: 50%;">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                </span>
              </a> 
            </div>            
            <p class="fw-bold" style="font-size: 25px;">{{ $clientsCount }}</p>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title">Products</h3>
              <a href="{{ route('proforma.index') }}">
                <span class="avatar" style="border-radius: 50%;">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2" /><path d="M3 6h18" /> <path d="M7 10h10" /><path d="M7 14h10" /></svg>
                </span>
              </a> 
            </div>            
            <p class="fw-bold" style="font-size: 25px;">{{ $productsCount}}</p>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title">Packing List</h3>
              <a href="{{ route('proforma.index') }}">
                <span class="avatar" style="border-radius: 50%;">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-package"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
                </span>
              </a> 
            </div>            
            <p class="fw-bold" style="font-size: 25px;">{{ $packingListCount }}</p>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title"> Total Final Invoice</h3>
              <a href="{{ url('/transaction') }}">
                <span class="avatar" style="border-radius: 50%;">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" /></svg>
                </span>
              </a>
            </div>            
            <p class="fw-bold" style="font-size: 25px;">
              ${{ $formattedTotalInvoice }}
              <span style="font-size: 14px; font-weight: normal;">/Day</span>
            </p>            
          </div>
        </div>
      </div>
      <div class="col-12 mt-2">
        <div class="row row-cards">
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a href="{{ route('proforma.index') }}" title="Proforma Invoice">
                      <span class="bg-red text-white avatar" style="border-radius: 50%;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
                      </span>
                    </a>                          
                  </div>
                  <div class="col">
                    <div class="text-secondary">
                      Menunggu Persetujuan
                  </div>
                  <div class="fw-bold" style="font-size: 17px;">
                    {{ $waitingApprove }}
                  </div>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a href="{{ route('proforma.index') }}" title="Proforma Invoice">
                      <span class="bg-green text-white avatar" style="border-radius: 50%;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                      </span>
                    </a> 
                  </div>
                  <div class="col">
                    <div class="text-secondary">
                      Disetujui
                  </div>
                    <div class="fw-bold" style="font-size: 17px;">
                      {{ $ApproveProforma }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a href="{{ url('/incomplete-invoice') }}" title="Unconfirmed Invoice">
                      <span class="bg-warning text-white avatar" style="border-radius: 50%;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M9 12l2 2l4 -4" /></svg>
                      </span>
                    </a> 
                  </div>
                  <div class="col">
                    <div class="text-secondary">
                      Menunggu Konfirmasi
                  </div>
                    <div class="fw-bold" style="font-size: 17px;">
                      {{ $unconfirmedInvoice }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a href="{{ url('/transaction') }}" title="Final Invoice">
                      <span class="bg-facebook text-white avatar" style="border-radius: 50%;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /></svg>
                      </span>
                    </a> 
                  </div>
                  <div class="col">
                    <div class="text-secondary">
                      Final Invoice
                  </div>
                    <div class="fw-bold" style="font-size: 17px;">
                      {{ $finalInvoice }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex mt-3" style="gap: 1rem;">
        <div class="card finalInvoice chart" style="flex: 12;">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title">Final Invoice</h3>
              <a href="{{ url('/transaction') }}" title="Final Invoice">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M17 7l-10 10" />
                  <path d="M8 7l9 0l0 9" />
                </svg>
              </a>
            </div>
            <div id="chart-completion-tasks" class="chart-lg"></div>
          </div>
        </div>
        <div class="card bop chart" style="flex: 4;">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <h3 class="card-title">Bill Of Payment</h3>
                <a href="{{ route('bill-of-payment.index') }}" title="bill of payment">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M17 7l-10 10" />
                    <path d="M8 7l9 0l0 9" />
                  </svg>
                </a>
              </div>
              <p class="fw-bold" style="font-size: 25px;">{{ $bopCount }}</p>
              <div id="chart-demo-pie" class="chart-lg"></div>
            </div>
          </div>
        </div>
      </div>      
      {{-- <div class="mt-3">
        <table class="table  table-bordered table-vcenter">
          <tbody>
            <tr>
              <td>Produk</td>
              <td>{{ $productsCount }}</td>
              <td>
                <a href="{{ url('/products') }}" class="text-success">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                </a>
              </td>
            </tr>
            <tr>
              <td>Komoditas</td>
              <td>{{ $commoditiesCount }}</td>
              <td>
                <a href="{{ url('/commodities') }}" class="text-success">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                </a>
              </td>
            </tr>
            <tr>
              <td>User</td>
              <td>{{ $usersCount }}</td>
              <td>
                <a href="{{ route('clients.index') }}" class="text-success">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                </a>
              </td>
            </tr>
            <tr>
              <td>Negara</td>
              <td>{{ $countriesCount }}</td>
              <td>
                <a href="{{ url('/countries') }}" class="text-success">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
      chart: {
        type: "donut",
        fontFamily: 'inherit',
        height: 220,
        sparkline: {
          enabled: true
        },
        animations: {
          enabled: false
        },
      },
      fill: {
        opacity: 1,
      },
      series: [<?php echo $lunasCount; ?>, <?php echo $belumLunasCount; ?>],
      labels: ["Lunas", "Belum Lunas"],
      tooltip: {
        theme: 'dark'
      },
      grid: {
        strokeDashArray: 4,
      },
      colors: [tabler.getColor("primary"), tabler.getColor("danger")],
      legend: {
        show: true,
        position: 'bottom',
        offsetY: 12,
        markers: {
          width: 10,
          height: 10,
          radius: 100,
        },
        itemMargin: {
          horizontal: 8,
          vertical: 8
        },
      },
      tooltip: {
        fillSeriesColor: false
      },
    })).render();
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk memuat data dari endpoint
    function fetchInvoiceData() {
      fetch('/invoice-data')
        .then(response => response.json())
        .then(data => {
          // Format data untuk ApexCharts
          const chartData = data.map(item => ({
            x: item.date, // Tanggal
            y: parseFloat(item.total) // Total
          }));

          // Inisialisasi grafik dengan data dinamis
          renderChart(chartData);
        })
        .catch(error => console.error('Error fetching invoice data:', error));
    }

    // Fungsi untuk merender grafik
    function renderChart(seriesData) {
      window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks'), {
        chart: {
          type: "bar",
          fontFamily: 'inherit',
          height: 240,
          parentHeightOffset: 0,
          toolbar: {
            show: false,
          },
          animations: {
            enabled: false
          },
        },
        plotOptions: {
          bar: {
            columnWidth: '50%',
          }
        },
        dataLabels: {
          enabled: false,
        },
        fill: {
          opacity: 1,
        },
        series: [{
          name: "Invoice Total",
          data: seriesData // Data dari controller
        }],
        tooltip: {
          theme: 'dark'
        },
        grid: {
          padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4
          },
          strokeDashArray: 4,
        },
        xaxis: {
          labels: {
            padding: 0,
          },
          tooltip: {
            enabled: false
          },
          axisBorder: {
            show: false,
          },
          type: 'datetime', // Gunakan tipe datetime
        },
        yaxis: {
          labels: {
            padding: 4
          },
        },
        colors: [tabler.getColor("primary")],
        legend: {
          show: false,
        },
      })).render();
    }

    // Panggil fungsi untuk memuat data
    fetchInvoiceData();
  });
</script>
@endsection