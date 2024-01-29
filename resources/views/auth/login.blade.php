@extends('layouts.app')

@section('title', 'Admin Login | E-Commerce')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h2 class="text-center">Admin Login</h2>
        </div>

        <div class="card-body">
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <form method="post" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection