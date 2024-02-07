@extends('layouts.app')

@section('title', 'Admin Login | E-Commerce')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h2 class="text-center">Sign UP</h2>
        </div>

        <div class="card-body">
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          
          @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          <form method="POST" action="{{ route('signup') }}">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
              <label for="phone_no" class="form-label">Phone Number</label>
              <input type="tel" id="phone_no" class="form-control" name="phone_no" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" id="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection