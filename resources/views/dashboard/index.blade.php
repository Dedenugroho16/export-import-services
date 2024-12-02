@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="grid-container">
        <div class="row row-deck row-cards">
          <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Sales</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item active" href="#">Last 7 days</a>
                            <a class="dropdown-item" href="#">Last 30 days</a>
                            <a class="dropdown-item" href="#">Last 3 months</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="h1 mb-3">75%</div>
                    <div class="d-flex mb-2">
                      <div>Conversion rate</div>
                      <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          7% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </span>
                      </div>
                    </div>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                        <span class="visually-hidden">75% Complete</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Revenue</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item active" href="#">Last 7 days</a>
                            <a class="dropdown-item" href="#">Last 30 days</a>
                            <a class="dropdown-item" href="#">Last 3 months</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2">$4,300</div>
                      <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          8% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div id="chart-revenue-bg" class="chart-sm"></div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">New clients</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item active" href="#">Last 7 days</a>
                            <a class="dropdown-item" href="#">Last 30 days</a>
                            <a class="dropdown-item" href="#">Last 3 months</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2">6,782</div>
                      <div class="me-auto">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                          0% <!-- Download SVG icon from http://tabler-icons.io/i/minus -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>
                        </span>
                      </div>
                    </div>
                    <div id="chart-new-clients" class="chart-sm"></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Active users</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item active" href="#">Last 7 days</a>
                            <a class="dropdown-item" href="#">Last 30 days</a>
                            <a class="dropdown-item" href="#">Last 3 months</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2">2,986</div>
                      <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          4% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </span>
                      </div>
                    </div>
                    <div id="chart-active-users" class="chart-sm"></div>
                  </div>
                </div>
              </div>         
              <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <a href="{{ route('proforma.index') }}">
                              <span class="bg-red text-white avatar" style="border-radius: 50%;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
                              </span>
                            </a>                          
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $waitingApprove }}
                            </div>
                            <div class="text-secondary">
                                Menunggu Persetujuan
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
                            <a href="{{ route('proforma.index') }}">
                              <span class="bg-green text-white avatar" style="border-radius: 50%;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                              </span>
                            </a> 
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $ApproveProforma }}
                            </div>
                            <div class="text-secondary">
                                Disetujui
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
                            <a href="{{ url('/incomplete-invoice') }}">
                              <span class="bg-warning text-white avatar" style="border-radius: 50%;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-progress-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M9 12l2 2l4 -4" /></svg>
                              </span>
                            </a> 
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $unconfirmedInvoice }}
                            </div>
                            <div class="text-secondary">
                                Menunggu Konfirmasi
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
                            <a href="{{ url('/transaction') }}">
                              <span class="bg-facebook text-white avatar" style="border-radius: 50%;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /></svg>
                              </span>
                            </a> 
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $finalInvoice }}
                            </div>
                            <div class="text-secondary">
                                Final Invoice
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex" style="gap: 1rem; align-items: stretch;">
                <div class="card traffic-summary" style="flex: 7;">
                  <div class="card-body">
                    <h3 class="card-title">Traffic Summary</h3>
                    <div id="chart-demo-area" class="chart-lg"></div>
                  </div>
                </div>
                <div class="card locations" style="flex: 3;">
                    <div class="card-table table-responsive">
                      <table class="table  table-bordered table-vcenter">
                        <tbody>
                          <tr>
                            <td>Client</td>
                            <td>{{ $clientsCount }}</td>
                            <td>
                              <a href="{{ route('clients.index') }}" class="text-success">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                              </a>
                            </td>                          
                          </tr>
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
                    </div>
                </div>
              </div>
              
        </div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-area'), {
      chart: {
        type: "area",
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
      dataLabels: {
        enabled: false,
      },
      fill: {
        opacity: .16,
        type: 'solid'
      },
      stroke: {
        width: 2,
        lineCap: "round",
        curve: "smooth",
      },
      series: [{
        name: "series1",
        data: [56, 40, 39, 47, 34, 48, 44]
      }, {
        name: "series2",
        data: [45, 43, 30, 23, 38, 39, 54]
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
        type: 'datetime',
      },
      yaxis: {
        labels: {
          padding: 4
        },
      },
      labels: [
        '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27'
      ],
      colors: [tabler.getColor("primary"), tabler.getColor("purple")],
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
    })).render();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Mengambil data dari controller Laravel
    var lunasCount = @json($lunasCount); // Data jumlah BoP yang lunas
    var belumLunasCount = @json($belumLunasCount); // Data jumlah BoP yang belum lunas

    window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
      chart: {
        type: "donut",
        fontFamily: 'inherit',
        height: 80,
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
      series: [lunasCount, belumLunasCount], // Data BoP Lunas dan Belum Lunas
      labels: ["Lunas", "Belum Lunas"], // Label untuk BoP Lunas dan Belum Lunas
      tooltip: {
        theme: 'dark'
      },
      grid: {
        strokeDashArray: 4,
      },
      colors: [tabler.getColor("primary"), tabler.getColor("danger")], // Warna untuk Lunas dan Belum Lunas
      legend: {
        show: true,
        position: 'right',

        markers: {
          width: 5,
          height: 5,
          radius: 40,
        },
      },
      tooltip: {
        fillSeriesColor: false
      },
    })).render();
  });
</script>

        {{-- <div class="d-flex flex-wrap justify-content-center">
            @if(auth()->user()->role === 'admin')
                <!-- Kartu untuk Client -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="color: #007bff;"></i> Clients
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                    </div>
                </div>
                <!-- Kartu untuk Produk -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-cogs" style="color: #003161;"></i> Products
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                        <a href="{{ url('/products') }}" class="btn btn-info btn-sm" style="background-color: #003161; color: white;">Lihat Produk</a>
                    </div>
                </div>
                <!-- Kartu untuk Komoditas -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-donate" style="color: #ffc107;"></i> Commodities
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                        <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                        <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                    </div>
                </div>
                <!-- Kartu untuk Negara -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-flag" style="color: #28a745;"></i> Countries
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                        <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                        <a href="{{ url('/countries') }}" class="btn btn-success btn-sm">Lihat Negara</a>
                    </div>
                </div>
                <!-- Kartu untuk Pengguna -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users-cog" style="color: #6f42c1;"></i> Users
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $usersCount }}</span></p>
                        <p class="card-text text-muted">Kelola data pengguna di sini.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-purple btn-sm">Lihat Pengguna</a>
                    </div>
                </div>
                <!-- Kartu untuk Data Perusahaan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-building" style="color: #C62E2E;"></i> Company Data
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                        <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                        <a href="{{ route('company.index') }}" class="btn btn-danger btn-sm" style="background-color: #C62E2E; color: white;">Lihat Data Perusahaan</a>
                    </div>
                </div>
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                            <!-- Dropdown Button (three dots icon) -->
                            <div class="dropdown d-inline float-end">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v" style="color: #185519;"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('proforma.index') }}">Proforma Invoices</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/incomplete-invoice') }}">Uncorfimed Invoices</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/transaction') }}">Final Invoice</a></li>
                                    <!-- Add more menu items as needed -->
                                </ul>
                            </div>
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>

                <!-- Kartu untuk Rekap Penjualan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-line" style="color: #914F1E;"></i> Sales Recap
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold">{{ $totalSales }}</span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.rekap') }}" class="btn btn-warning btn-sm" style="background-color: #914F1E; color: white;">Lihat Rekap</a>
                    </div>
                </div>
                <!-- Kartu untuk Bill of Payments -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-file-invoice-dollar" style="color: #E90074;"></i> Bill of Payments
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $billsCount }}</span></p>
                        <p class="card-text text-muted">Lihat rekap pembayaran Anda di sini.</p>
                        <a href="{{ route('bill-of-payment.index') }}" class="btn btn-danger btn-sm" style="background-color: #E90074; color: white;">Lihat Rekap</a>
                    </div>
                </div>
                <!-- Kartu untuk Report -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-pie" style="color: #373A40;"></i> Report
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold"></span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.AccountStatement') }}" class="btn btn-info btn-sm" style="background-color: #373A40; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'operator')
                <!-- Kartu untuk Client -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="color: #007bff;"></i> Clients
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                    </div>
                </div>
                <!-- Kartu untuk Produk -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-cogs" style="color: #003161;"></i> Products
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                        <a href="{{ url('/products') }}" class="btn btn-info btn-sm" style="background-color: #003161; color: white;">Lihat Produk</a>
                    </div>
                </div>
                <!-- Kartu untuk Komoditas -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-donate" style="color: #ffc107;"></i> Commodities
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                        <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                        <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                    </div>
                </div>
                <!-- Kartu untuk Negara -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-flag" style="color: #28a745;"></i> Countries
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                        <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                        <a href="{{ url('/countries') }}" class="btn btn-success btn-sm">Lihat Negara</a>
                    </div>
                </div>
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>
                <!-- Kartu untuk Rekap Penjualan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-line" style="color: #914F1E;"></i> Sales Recap
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold">{{ $totalSales }}</span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.rekap') }}" class="btn btn-warning btn-sm" style="background-color: #914F1E; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'director')
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>
                <!-- Kartu untuk Data Perusahaan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-building" style="color: #C62E2E;"></i> Company Data
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                        <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                        <a href="{{ route('company.index') }}" class="btn btn-danger btn-sm" style="background-color: #C62E2E; color: white;">Lihat Data Perusahaan</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'finance')
                <!-- Kartu untuk Bill of Payments -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-file-invoice-dollar" style="color: #E90074;"></i> Bill of Payments
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $billsCount }}</span></p>
                        <p class="card-text text-muted">Lihat rekap pembayaran Anda di sini.</p>
                        <a href="{{ route('bill-of-payment.index') }}" class="btn btn-danger btn-sm" style="background-color: #E90074; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @endif
        </div> --}}
        <style>
    /* CSS untuk mengatur tinggi kartu agar seragam */
    .small-card {
        width: 12rem; /* Lebar setiap kartu */
        font-size: 0.75rem; /* Ukuran font lebih kecil */
        margin: 0.5rem; /* Jarak antar kartu */
        border-radius: 0.5rem; /* Sudut melengkung pada setiap kartu */
        overflow: hidden; /* Hapus elemen yang keluar dari batas kartu */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Menggunakan box-shadow untuk efek border */
    }

    .small-card:hover {
        transform: scale(1.05); /* Zoom sedikit saat hover */
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5); /* Menggunakan box-shadow daripada border */
    }

    .small-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Ruang di antara elemen dalam kartu */
        padding: 0.5rem; /* Padding kecil */
    }

    .small-card .btn {
        font-size: 0.7rem; /* Ukuran font tombol lebih kecil */
        padding: 0.2rem 0.4rem; /* Padding kecil untuk tombol */
        margin-top: auto; /* Pastikan tombol selalu berada di bagian bawah */
    }
</style>

    </div>
</div>
@endsection
