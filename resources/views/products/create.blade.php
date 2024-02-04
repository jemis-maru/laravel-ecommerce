@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
  <h2>Add Product</h2>
  <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="model_name" class="form-label">Model Name</label>
      <input type="text" class="form-control" id="model_name" name="model_name" required>
    </div>
    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity</label>
      <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-select" id="category_id" name="category_id" required>
        <option value="" disabled selected>Select a category</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="file" class="form-control" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
  </form>
</div>
@endsection