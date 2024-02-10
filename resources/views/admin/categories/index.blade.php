@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
  </div>
  <form action="{{ route('categories.index') }}" method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="query" class="form-control" value="{{ request()->input('query') }}" placeholder="Search categories...">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($categories->isEmpty())
  <div class="alert alert-info">No categories found.</div>
  @else
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{ $category->id }}</td>
          <td>{{ $category->name }}</td>
          <td>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">Delete</button>
          </td>
        </tr>
  
        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete the category "{{ $category->name }}"?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
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
    {{ $categories->render('ui.custom_pagination') }}
  </div>
  @endif
</div>
@endsection