<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'E-Commerce')</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <style>
    .h2 {
      margin: 0;
    }

    body {
      min-height: 100vh;
    }

    .main-container {
      margin-top: 40px;
      padding: 20px;
    }

    header {
      z-index: 1;
    }

    header nav {
      background-color: #008b9b;
    }

    header .navbar-brand {
      color: #fff !important;
      font-weight: bolder;
    }

    header .h2 {
      color: #fff !important;
      font-weight: bolder;
    }

    .min-h-100 {
      min-height: 100vh;
    }

    .cursor-pointer {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="min-h-100">
    <header>
      <nav class="navbar navbar-light fixed-top">
        <div class="container-fluid align-items-center justify-content-between gap-4">
          <div class="d-flex gap-4 align-items-center">
            <h1 class="h2">E-Commerce</h1>
          </div>
          <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
              John Doe
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
              <li><a class="dropdown-item" href="/myprofile">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="post" action="{{ route('logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="min-h-100">
      <div class="container main-container">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>