<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard | E-Commerce')</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <style>
    .h2 {
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-container {
      flex: 1;
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

    .sidebar {
      width: 200px;
      background: rgb(0, 0, 0, 0.5);
      color: #fff;
      padding: 20px;
      padding-top: 80px;
      min-height: 100vh;
      position: fixed;
      left: 0;
      display: none;
      z-index: 500;
    }

    .sidebar a {
      font-weight: bolder;
      text-decoration: none;
      color: #ffffff !important;
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
            <button onclick="toggleSidebar()" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
          </div>
          <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
              John Doe
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
              <li><a class="dropdown-item" href="/profile">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="post" action="{{ route('admin.logout') }}">
                  @csrf
                  <button class="dropdown-item" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="d-flex min-h-100">
      <aside class="sidebar" id="sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/categories">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/users">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/products">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/comments">Comments</a>
          </li>
        </ul>
      </aside>
      <div class="container main-container">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script>
    const toggleSidebar = () => {
      const sidebar = document.getElementById('sidebar');
      if (sidebar.style.display === "block") {
        sidebar.style.display = "none";
      } else {
        sidebar.style.display = "block";
      }
    }
  </script>

</body>

</html>