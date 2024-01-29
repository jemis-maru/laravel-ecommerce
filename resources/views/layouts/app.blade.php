<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'E-Commerce')</title>

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container">
    @yield('content')
  </div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>