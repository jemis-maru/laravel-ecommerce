@extends('layouts.frontend')

@section('title', 'Products | E-Commerce')

@section('content') 
<div class="container mt-5">
  <form action="{{ route('listing') }}" method="GET" class="mb-4">
    <div class="input-group">
      <input type="text" name="query" class="form-control" value="{{ request()->input('query') }}" placeholder="Search products...">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>
  <div class="row">
    @foreach($products as $product)
    <div class="col-md-4">
      <div class="product-card">
        <img src="{{ Storage::disk('s3')->url($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
        <div class="card-body">
          <h5 class="card-title">{{ $product->name }}</h5>
          <p class="card-text">Model: {{ $product->model_name }}</p>
          <p class="card-text">Quantity: {{ $product->quantity }}</p>
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#commentModal{{ $product->id }}">
            Comments
          </button>
        </div>
      </div>
    </div>

    <div class="modal fade" id="commentModal{{ $product->id }}" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="comment-section modal-body">
            <h6>Comments:</h6>
            <ul>
              @forelse($product->comments as $comment)
              <li>{{ $comment->comment }}</li>
              @empty
              <li>No comments yet.</li>
              @endforelse
            </ul>
          </div>
          @if(!$product->comments()->where('user_id', Auth::guard('user')->id())->exists())
          <form method="POST" action="{{ route('product.addComment', $product->id) }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment" required></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Comment</button>
            </div>
          </form>
          @endif
        </div>
      </div>
    </div>
    @endforeach
    
    <div class="mt-5 d-flex justify-content-end">
      {{ $products->render('ui.custom_pagination') }}
    </div>
  </div>
</div>
@endsection