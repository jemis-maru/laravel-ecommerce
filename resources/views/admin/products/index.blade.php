@extends('layouts.dashboard')

@section('title', 'Products | Dashboard')

@section('page-title', 'Products')

@section('content')
<div class="container mt-4">
  <div class="mb-3">
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
  </div>
  <form action="{{ route('products.index') }}" method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="query" class="form-control" value="{{ request()->input('query') }}" placeholder="Search products...">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($products->isEmpty())
  <div class="alert alert-info">No products found.</div>
  @else
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Category</th>
          <th>Model Name</th>
          <th>Quantity</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->category->name }}</td>
          <td>{{ $product->model_name }}</td>
          <td>{{ $product->quantity }}</td>
          <td>
            @if($product->image)
            <img src="{{ Storage::disk('s3')->url($product->image) }}" alt="Product Image" style="max-width: 100px;">
            @else
            No Image
            @endif
          </td>
          <td>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">Delete</button>
          </td>
        </tr>

        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete the product "{{ $product->name }}"?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('products.destroy', $product) }}" method="POST">
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
    {{ $products->render('ui.custom_pagination') }}
  </div>
  @endif
</div>
@endsection