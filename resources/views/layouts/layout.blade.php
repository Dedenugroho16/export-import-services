<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Default Title')</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Sweetalert CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #d1d5db;
            /* Gray-300 */
        }

        .nav-link-icon {
            margin-right: 1rem;
            display: flex;
            align-items: center;
        }

        .nav-link-title {
            font-size: 1rem;
            font-weight: 500;
        }

        table {
            table-layout: auto;
            width: 100%;
        }

        /* Mengubah tampilan search bar */
        .dataTables_filter input[type="search"] {
            width: 300px;
            padding: 3px;
            border-radius: 4px;
            border: 1px solid #b1b1b1;
            outline: none;
            transition: 0.3s;
            margin: 15px;
        }

        /* Efek ketika fokus pada search bar */
        .dataTables_filter input[type="search"]:focus {
            border-color: #ff9800;
            box-shadow: 0 0 5px rgba(255, 152, 0, 0.8);
        }

        .dataTables_filter label {
            font-size: 15px;
            font-weight: bold;
            margin-right: 15px;
            color: #535353
        }

        .dataTables_length label {
            font-size: 15px;
            font-weight: bold;
            color: #535353;
            margin: 15px;
        }

        /* Menyesuaikan gaya dropdown untuk memilih jumlah entri */
        .dataTables_length select {
            padding-left: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            transition: 0.3s;
        }

        /* Efek saat dropdown difokuskan */
        .dataTables_length select:focus {
            border-color: #ff9800;
            box-shadow: 0 0 5px rgba(255, 152, 0, 0.8);
        }

        .table-wrapper, .table-responsive {
            overflow: visible;
        }

        #rekapTable, 
        #rekapTable .table-wrapper, 
        #rekapTable .table-responsive {
            overflow: auto;
        }
    </style>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="layout-fluid">
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href=".">
            <img src="{{ asset('storage/logo2.png') }}" alt="Logo" class="navbar-brand-image" style="width: 150px; height: auto;">
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M12 3v6" />
                                    <path d="M12 15v6" />
                                    <path d="M3 12h6" />
                                    <path d="M15 12h6" />
                                    <path d="M5.6 5.6l4.2 4.2" />
                                    <path d="M18.4 18.4l-4.2 -4.2" />
                                    <path d="M18.4 5.6l-4.2 4.2" />
                                    <path d="M5.6 18.4l4.2 -4.2" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Client</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <path d="M3 6h18" />
                                    <path d="M7 10h10" />
                                    <path d="M7 14h10" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Produk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/commodities') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M9 12h6m-3 -3v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Komoditas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/countries') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                    <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                    <path d="M11.5 3a17 17 0 0 0 0 18" />
                                    <path d="M12.5 3a17 17 0 0 1 0 18" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Negara
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="7" r="4" />
                                    <path d="M20 21l-2 -2a5 5 0 0 0 -7 -7l-5 5" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Data User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.index')}}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M5 21v-14l8 -4v18" /><path d="M19 21v-10l-6 -4" /><path d="M9 9l0 .01" /><path d="M9 12l0 .01" /><path d="M9 15l0 .01" /><path d="M9 18l0 .01" /></svg>
                            </span>
                            <span class="nav-link-title">
                                Data Perusahaan
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.rekap') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /></svg>
                            </span>
                            <span class="nav-link-title">Rekap Sales</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="6" cy="19" r="2" />
                                    <circle cx="17" cy="19" r="2" />
                                    <path d="M17 17h-11v-14h-2" />
                                    <path d="M6 5l14 1l-1 7h-13" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Transaksi</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('proforma.index') }}">
                                <span class="nav-link-title">Proforma Invoices</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('/incomplete-invoice') }}">
                                <span class="nav-link-title">Unconfirmed Invoices</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('/transaction') }}">
                                <span class="nav-link-title">Rekap Invoice</span>
                            </a>
                        </div>
                    </li>
                @endif
                @if(auth()->user()->role === 'operator')
                <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M12 3v6" />
                                    <path d="M12 15v6" />
                                    <path d="M3 12h6" />
                                    <path d="M15 12h6" />
                                    <path d="M5.6 5.6l4.2 4.2" />
                                    <path d="M18.4 18.4l-4.2 -4.2" />
                                    <path d="M18.4 5.6l-4.2 4.2" />
                                    <path d="M5.6 18.4l4.2 -4.2" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Client</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <path d="M3 6h18" />
                                    <path d="M7 10h10" />
                                    <path d="M7 14h10" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Produk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/commodities') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M9 12h6m-3 -3v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Komoditas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/countries') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="3.6" y1="9" x2="20.4" y2="9" />
                                    <line x1="3.6" y1="15" x2="20.4" y2="15" />
                                    <path d="M11.5 3a17 17 0 0 0 0 18" />
                                    <path d="M12.5 3a17 17 0 0 1 0 18" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Negara
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.rekap') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /></svg>
                            </span>
                            <span class="nav-link-title">Rekap Sales</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="6" cy="19" r="2" />
                                    <circle cx="17" cy="19" r="2" />
                                    <path d="M17 17h-11v-14h-2" />
                                    <path d="M6 5l14 1l-1 7h-13" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Transaksi</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('proforma.index') }}">
                                <span class="nav-link-title">Proforma Invoice</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('/transaction') }}">
                                <span class="nav-link-title">Invoice</span>
                            </a>
                        </div>
                    </li>
                @endif

                {{-- Director menu --}}
                @if(auth()->user()->role === 'director')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.index')}}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M5 21v-14l8 -4v18" /><path d="M19 21v-10l-6 -4" /><path d="M9 9l0 .01" /><path d="M9 12l0 .01" /><path d="M9 15l0 .01" /><path d="M9 18l0 .01" /></svg>
                            </span>
                            <span class="nav-link-title">
                                Data Perusahaan
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="6" cy="19" r="2" />
                                    <circle cx="17" cy="19" r="2" />
                                    <path d="M17 17h-11v-14h-2" />
                                    <path d="M6 5l14 1l-1 7h-13" />
                                </svg>
                            </span>
                            <span class="nav-link-title">Transaksi</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('proforma.index') }}">
                                <span class="nav-link-title">Proforma Invoice</span>
                            </a>
                            <a class="dropdown-item" href="{{ url('/transaction') }}">
                                <span class="nav-link-title">Invoice</span>
                            </a>
                        </div>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</aside>


        <div class="page-wrapper">
            <div class="mb-3">
                <header class="navbar navbar-expand-md d-print-none">
                    <div class="container-xl">
                        <h1 id="page-title"
                            class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3"
                            style="font-size: 1.5rem;">
                            @yield('title', 'Default Title')
                        </h1>
                        <div class="navbar-nav flex-row order-md-last">
                            <div class="d-none d-md-flex">
                                <div class="nav-item dropdown d-none d-md-flex me-3">
                                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                        aria-label="Show notifications">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="grey"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                        </svg>
                                        <span class="badge bg-red"></span>
                                    </a>
                                    <div
                                        class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Last updates</h3>
                                            </div>
                                            <div class="list-group list-group-flush list-group-hoverable">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto"><span
                                                                class="status-dot status-dot-animated bg-red d-block"></span>
                                                        </div>
                                                        <div class="col text-truncate">
                                                            <a href="#" class="text-body d-block">Example 1</a>
                                                            <div class="d-block text-secondary text-truncate mt-n1">
                                                                Change deprecated html tags to text decoration classes
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                    <!-- Menggunakan gambar dari database atau gravatar sebagai default -->
                                    <span class="avatar avatar-sm rounded-circle"
                                        style="background-image: url('{{ Auth::user()->profile_picture_url ? asset('storage/' . Auth::user()->profile_picture_url) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp' }}'); border-radius: 50%;"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                                        <i class="fas fa-user me-2"></i> Profil
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-cog me-2"></i> Pengaturan
                                    </a>
                                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="button" class="dropdown-item" onclick="confirmLogout()">
                                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <!-- Page body -->
            <div class="content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-md-auto ms-md-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary" rel="noopener"
                                        target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary" rel="noopener"
                                        target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md">
                            <div class="text-center">
                                <a href="." class="link-secondary">Your Company</a> &copy; 2024
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS files -->
    <script src="{{ asset('dist/js/tabler.min.js') }}"></script>

    <!-- DataTables JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan keluar dari sesi ini, pastikan telah menyimpan pekerjaan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Ya, keluar',
            cancelButtonText: 'Batal',
            buttonsStyling: true,  
            showClass: {
                popup: 'swal2-show', 
                backdrop: 'swal2-backdrop-show',
                icon: 'swal2-icon-show'
            },
            hideClass: {
                popup: 'swal2-hide', 
                backdrop: 'swal2-backdrop-hide',
                icon: 'swal2-icon-hide'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
        }
    </script>
    
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>
