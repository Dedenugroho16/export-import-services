<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>Dashboard</title>
  <!-- CSS files -->
  <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet"/>
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
      color: #d1d5db; /* Gray-300 */
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
</head>
<body class="layout-fluid">
  <div class="page">
    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
          <a href=".">
            <img src="{{ asset('static/logo.svg') }}" width="110" height="32" alt="Tabler" class="navbar-brand-image">
          </a>
        </h1>
        <div class="collapse navbar-collapse" id="sidebar-menu">
          <ul class="navbar-nav pt-lg-3">
            <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Home
                </span>
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('clients.index') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="7" r="4" />
                    <path d="M5 21v-4a7 7 0 0 1 14 0v4" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Clients
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/consignee') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                    <path d="M4 9h16M9 4v16"/>
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <path d="M3 6h18"/>
                    <path d="M7 10h10"/>
                    <path d="M7 14h10"/>
                  </svg>
                </span>
                <span class="nav-link-title">
                  Product
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/commodities') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="12" r="9" />
                    <path d="M9 12h6m-3 -3v6" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Commodity
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/detail-products') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                    <path d="M8 8h8v8H8z"/>
                    <path d="M8 12h8"/>
                  </svg>
                </span>
                <span class="nav-link-title">
                  Detail Product
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/countries') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M21 12c0 4.418 -3.582 8 -8 8s-8 -3.582 -8 -8s3.582 -8 8 -8s8 3.582 8 8z" />
                    <path d="M12 4v8" />
                    <path d="M4 12h8" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Country
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>

    <div class="page-wrapper">
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
                  <a href="#" class="link-secondary" rel="noopener" target="_blank">Privacy</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="link-secondary" rel="noopener" target="_blank">Terms</a>
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
</body>
</html>
