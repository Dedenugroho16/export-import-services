<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign In</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Masuk ke akun anda</h2>
            <form action="{{ route('login') }}" method="post" autocomplete="off">
            @csrf
            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            {{-- password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                </div>
            </div>
              {{-- Notifikasi Login Gagal --}}
                @if($errors->has('failed'))
                <div class="alert alert-danger">
                    {{ $errors->first('failed') }}
                </div>
              @endif
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input"/>
                  <span class="form-check-label">Ingat saya di perangkat ini</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>