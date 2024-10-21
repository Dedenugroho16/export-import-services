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
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: 'Inter', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #ff007f 0%, #00bfff 100%);
      }

      .card {
        background: #fff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        max-width: 400px;
        width: 100%;
        text-align: center;
      }

      .card img {
        max-width: 80px;
        margin-bottom: 1.5rem;
      }
      h2 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: #333;
      }
      .form-control {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: none;
        background: rgba(255, 255, 255, 0.8);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      .form-control:focus {
        background: rgba(255, 255, 255, 1);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        outline: none;
      }
      .btn-primary {
        background-color: #3498db;
        border: none;
        padding: 0.75rem;
        font-size: 1rem;
        border-radius: 12px;
        width: 100%;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
      }
      .btn-primary:hover {
        background-color: #2980b9;
        transform: translateY(-3px);
      }
      .form-check-label {
        color: #666;
      }
    </style>
  </head>
  <body>
    <div class="card">
      <!-- Company Logo -->
      <div class="text-center">
        <img src="{{ Storage::url($company->logo)}}" alt="Company Logo" class="img-fluid">
      </div>
      <!-- Login Form -->
      <h2>Masuk ke akun anda</h2>
      <form action="{{ route('login') }}" method="post" autocomplete="off">
        @csrf
        {{-- Email --}}
        <div class="mb-3">
          <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Login Failed Notification --}}
        @if($errors->has('failed'))
          <div class="alert alert-danger">
            {{ $errors->first('failed') }}
          </div>
        @endif

        {{-- Remember Me --}}
        <div class="mb-2 text-start">
          <label class="form-check">
            <input type="checkbox" class="form-check-input"/>
            <span class="form-check-label">Ingat saya di perangkat ini</span>
          </label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Masuk</button>
      </form>
    </div>

    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>
