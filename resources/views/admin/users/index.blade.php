@extends('layouts.dashboard')

@section('title', 'Users | Dashboard')

@section('page-title', 'Users')

@section('content')
<div class="container mt-4">
  <form action="{{ route('users.index') }}" method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="query" class="form-control" value="{{ request()->input('query') }}" placeholder="Search users...">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($users->isEmpty())
  <div class="alert alert-info">No users found.</div>
  @else
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone No.</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->phone_no }}</td>
          <td>
            <button class="btn btn-{{$user->is_active ? 'danger' : 'success'}}" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
          </td>
        </tr>

        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} the user?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('users.toggle', $user) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-{{$user->is_active ? 'danger' : 'success'}}">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-end">
    {{ $users->render('ui.custom_pagination') }}
  </div>
  @endif
</div>
@endsection