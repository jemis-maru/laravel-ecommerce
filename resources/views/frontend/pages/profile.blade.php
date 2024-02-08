@extends('layouts.frontend')

@section('title', 'Dashboard')

@section('content')
<div class="row mt-3">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">Profile</h2>
          </div>

          <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="post" action="{{ route('updateProfile') }}">
              @csrf
              @method('post')

              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
              </div>

              <div class="mb-3">
                <label for="phone_no" class="form-label">Phone Number</label>
                <input type="phone_no" name="phone_no" id="phone_no" class="form-control" value="{{ $user->phone_no }}" required>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                  Change Password
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mt-3">
            <div class="col">
              <form method="post" action="{{ route('changePassword') }}">
                @csrf

                <div class="mb-3">
                  <label for="current_password" class="form-label">Current Password</label>
                  <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label for="new_password" class="form-label">New Password</label>
                  <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                  <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Change Password</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection