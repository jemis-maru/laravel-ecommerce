@extends('layouts.app')

@section('title', 'Login | E-Commerce')

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Reset Password</div>

        <div class="card-body">
          @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">E-Mail Address</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">
              Send Password Reset Link
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection