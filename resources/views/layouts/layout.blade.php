<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
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
                        <img src="{{ asset('static/logo.svg') }}" width="110" height="32" alt="Tabler"
                            class="navbar-brand-image">
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
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clients.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="7" r="4" />
                                        <path d="M5 21v-4a7 7 0 0 1 14 0v4" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Client
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('consignees.index') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <path d="M4 9h16M9 4v16" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Consignee
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/products') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <path d="M3 6h18" />
                                        <path d="M7 10h10" />
                                        <path d="M7 14h10" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Produk
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/commodities') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M9 12h6m-3 -3v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Komoditas
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/countries') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M21 12c0 4.418 -3.582 8 -8 8s-8 -3.582 -8 -8s3.582 -8 8 -8s8 3.582 8 8z" />
                                        <path d="M12 4v8" />
                                        <path d="M4 12h8" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Negara
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/transaction/create') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M21 12c0 4.418 -3.582 8 -8 8s-8 -3.582 -8 -8s3.582 -8 8 -8s8 3.582 8 8z" />
                                        <path d="M12 4v8" />
                                        <path d="M4 12h8" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Transaksi
                                </span>
                            </a>
                        </li>
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
                            <a href=".">
                                Dashboard
                            </a>
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
                                <a href="#" class="nav-link d-flex lh-1 text-reset p-0"
                                    data-bs-toggle="dropdown" aria-label="Open user menu">
                                    <span class="avatar avatar-sm rounded-circle"
                                        style="background-image: url('https://www.gravatar.com/avatar/?d=mp'); border-radius: 50%;"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <a href="#" class="dropdown-item">Profil</a>
                                    <a href="./settings.html" class="dropdown-item">Pengaturan</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Keluar</button>
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


    <!-- JS files -->
    <script src="{{ asset('dist/js/tabler.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pages = {
                "/": "Dashboard", // Default
                "/dashboard": "Dashboard",
                "/clients": "Client",
                "/consignees": "Consignee",
                "/products": "Produk",
                "/commodities": "Commoditas",
                "/detail-products": "Detail Produk",
                "/countries": "Negara",
                "/transaction/create": "Transaksi",
                "/invoices": "Invoices",
                "/settings": "Settings"
            };

            const dynamicPages = {
                "/clients": "Client",
                "/consignees": "Consignee",
                "/commodities": "Komoditas",
                "/products": "Produk",
                "/detail-products": "Detail Produk",
                "/countries": "Negara",
                "/transaction": "Transaksi"
            };

            const updateTitle = () => {
                const path = window.location.pathname;

                // Cek untuk path yang eksak terlebih dahulu
                let title = pages[path] || pages["/"];

                // Cek URL dinamis berdasarkan awalan
                for (let prefix in dynamicPages) {
                    if (path.startsWith(prefix)) {
                        title = dynamicPages[prefix];
                        break;
                    }
                }

                document.querySelector("#page-title").innerHTML = `<a href=".">${title}</a>`;
            };

            updateTitle();
            window.addEventListener("popstate", updateTitle);
        });
    </script>
</body>

</html>
