@extends('layouts.layout')
@section('title', 'Dashboard')
@section('navbar-title')
    Halo {{$userName}}
@endsection
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
                <span class="avatar" style="border-radius: 50%; color: #377ff3">
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
              <h3 class="card-title"> Total Final Invoice</h3>
              <a href="{{ url('/transaction') }}">
                <span class="avatar" style="border-radius: 50%; color: #377ff3">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-invoice"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 7l1 0" /><path d="M9 13l6 0" /><path d="M13 17l2 0" /></svg>
                </span>
              </a>
            </div>            
            <p class="fw-bold" style="font-size: 25px;">
              ${{ number_format($totalFinalInvoice, 0, '.', ',') }}
              <span style="font-size: 14px; font-weight: normal;">/Today</span>
            </p>            
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title">Total Bill Of Payment</h3>
              <a href="{{ route('proforma.index') }}">
                <span class="avatar" style="border-radius: 50%; color: #377ff3">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-dollar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" /><path d="M12 17v1m0 -8v1" /></svg>
                </span>
              </a> 
            </div>            
            <p class="fw-bold" style="font-size: 25px;">${{ number_format($sumTotalBop, 0, '.', ',') }}</p>
          </div>
        </div>
      </div>
      <!-- Card 4 -->
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h3 class="card-title"> Total Payment Detail</h3>
              <a href="{{ url('/transaction') }}">
                <span class="avatar" style="border-radius: 50%; color: #377ff3">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" /></svg>
                </span>
              </a>
            </div>            
            <p class="fw-bold" style="font-size: 25px;">${{ number_format($sumTotalPayment, 0, '.', ',') }}</p>           
          </div>
        </div>
      </div>
      <div class="col-12 mt-3">
        <div class="row row-cards">
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <a href="{{ route('proforma.index') }}" title="Proforma Invoice">
                      <span class="text-white avatar" style="border-radius: 50%; background:#EF4444">
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
                      <span class="text-white avatar" style="border-radius: 50%; background: #01bd7e">
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
                      <span class="text-white avatar" style="border-radius: 50%; background: #F59E0B">
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
      <div class="col-12 mt-3">
        <div class="row row-cards">
          <div class="col-sm-6 col-lg-9">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="d-flex align-items-center justify-content-between mb-3">
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
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="card-title">Bill Of Payment</h3>
                    <a href="{{ route('bill-of-payment.index') }}" title="bill of payment">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-up-right">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M17 7l-10 10" />
                        <path d="M8 7l9 0l0 9" />
                      </svg>
                    </a>
                  </div>
                  <div id="chart-demo-pie" class="chart-lg"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container py-4">
        <div class="row g-4">
          <!-- Section: Data Summary -->
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body p-0">
                <table class="table table-hover mb-0">
                  <tbody>
                    <tr>
                      <td>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-buildings me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" /><path d="M16 8h2c1 0 2 1 2 2v11" /><path d="M3 21h18" /><path d="M10 12v0" /><path d="M10 16v0" /><path d="M10 8v0" /><path d="M7 12v0" /><path d="M7 16v0" /><path d="M7 8v0" /><path d="M17 12v0" /><path d="M17 16v0" /></svg>
                        Perusahaan Client
                      </td>
                      <td class="text-end"><strong>{{ $clientCompany }}</strong></td>
                      <td>
                        <a href="{{ route('client-companies.index') }}" class="text-primary" title="Perusahaan Client">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-package me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
                        Packing List
                      </td>
                      <td class="text-end"><strong>{{ $packingListCount }}</strong></td>
                      <td>
                        <a href="{{ url('/transaction') }}" class="text-primary" title="Packing List">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-bag-search me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-2.926a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304h11.339a2 2 0 0 1 1.977 2.304l-.117 .761" /><path d="M9 11v-5a3 3 0 0 1 6 0v5" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                        Produk
                      </td>
                      <td class="text-end"><strong>{{ $productsCount }}</strong></td>
                      <td>
                        <a href="{{ url('/products') }}" class="text-primary" title="Produk">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-packages me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M2 13.5v5.5l5 3" /><path d="M7 16.545l5 -3.03" /><path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M12 19l5 3" /><path d="M17 16.5l5 -3" /><path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" /><path d="M7 5.03v5.455" /><path d="M12 8l5 -3" /></svg>
                        Komoditas
                      </td>
                      <td class="text-end"><strong>{{ $commoditiesCount }}</strong></td>
                      <td>
                        <a href="{{ url('/commodities') }}" class="text-primary" title="Komoditas">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </a>
                      </td>
                    </tr>
                    @if (auth()->user()->role === 'admin')
                  <tr>
                    <td>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users me-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                      </svg>
                      User
                    </td>
                    <td class="text-end"><strong>{{ $usersCount }}</strong></td>
                    <td>
                      <a href="{{ route('users.index') }}" class="text-primary" title="Data User">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M3 17l6 -6l4 4l8 -8" />
                          <path d="M14 7l7 0l0 7" />
                        </svg>
                      </a>
                    </td>
                  </tr>
                  @else
                  <tr>
                    <td>
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                      </svg>
                      Consignee
                    </td>
                    <td class="text-end"><strong>{{ $consigneeCount }}</strong></td>
                    <td>
                      <a href="{{ route('clients.index') }}" class="text-primary" title="Data Consignee">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M3 17l6 -6l4 4l8 -8" />
                          <path d="M14 7l7 0l0 7" />
                        </svg>
                      </a>
                    </td>
                  </tr>
                  @endif
                    <tr>
                      <td>
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M3.6 9h16.8" /><path d="M3.6 15h16.8" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 1 0 18" /></svg>
                        Negara
                      </td>
                      <td class="text-end"><strong>{{ $countriesCount }}</strong></td>
                      <td>
                        <a href="{{ url('/countries') }}" class="text-primary" title="Negara">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Section: Chart -->
          <div class="col-lg-8">
            <div class="card shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                  <!-- Pie Chart -->
                  <div id="chart-pie" style="height: 250; width: 60%;"></div>
                  <!-- Data Summary -->
                  <div class="d-flex flex-column align-items-start" style="width: 35%;">
                    <p style="font-weight: bold;">Total Bill of Payment</p>
                    <div class="d-flex align-items-center mb-3">
                      <span class="dot-indicator me-2" style="background-color: #3B82F6; width: 20px; height: 20px;"></span>
                      <div>
                        <span style="font-size: 18px;">${{ number_format($totalLunas, 0, '.', ',') }}</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center">
                      <span class="dot-indicator me-2" style="background-color: #EF4444; width: 20px; height: 20px;"></span>
                      <div>
                        <span style="font-size: 18px;">${{ number_format($totalBelumLunas, 0, '.', ',') }}</span>
                      </div>
                    </div>
                  </div>                                   
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .card{
    border-radius: 15px;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts &&
      new ApexCharts(document.getElementById("chart-demo-pie"), {
        chart: {
          type: "donut",
          fontFamily: "inherit",
          height: 250,
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
          theme: "dark"
        },
        grid: {
          strokeDashArray: 4,
        },
        colors: ['#3B82F6', '#EF4444'],
        legend: {
          show: true,
          position: "bottom",
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
        plotOptions: {
          pie: {
            donut: {
              size: "65%", // Ukuran lingkaran dalam
              labels: {
                show: true,
                total: {
                  show: true,
                  label: "Total",
                  fontSize: "14px",
                  fontFamily: "inherit",
                  color: "#373d3f",
                  formatter: function () {
                    return "<?php echo $lunasCount + $belumLunasCount; ?>"; // Menampilkan jumlah total
                  },
                },
              },
            },
          },
        },
        tooltip: {
          fillSeriesColor: false
        },
      }).render();
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
          type: 'datetime',
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
<script>
  document.addEventListener("DOMContentLoaded", function () {
    window.ApexCharts && (new ApexCharts(document.getElementById('chart-pie'), {
      chart: {
        type: "pie",
        height: 260,
        toolbar: {
          show: false
        }
      },
      labels: ['Sudah Lunas', 'Belum Lunas'],
      series: [{{ $totalLunas }}, {{ $totalBelumLunas }}],
      colors: ['#3B82F6', '#EF4444'],
      legend: {
        show: true,
        position: 'bottom',
        fontSize: '14px',
        labels: {
          colors: ['#000']
        },
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return val.toFixed(1) + "%";
        },
        style: {
          fontSize: '14px',
          fontFamily: 'Arial, sans-serif',
          fontWeight: 'bold',
          colors: ['#000']
        }
      },
    })).render();
  });
</script>
@endsection