@extends('layouts.dashboard')

@section('title', 'Category | Dashboard')

@section('page-title', 'Category')

@section('content')
<div class="container">
  <h2>Add Category</h2>
  <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Category</button>
  </form>
</div>
@endsection