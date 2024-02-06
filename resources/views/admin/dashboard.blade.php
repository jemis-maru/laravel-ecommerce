@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')<div class="container mt-5">
  <h1>Dashboard</h1>
  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Customers</h5>
          <p class="card-text">{{ $customerCount }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Categories</h5>
          <p class="card-text">{{ $categoryCount }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Products</h5>
          <p class="card-text">{{ $productCount }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Comments</h5>
          <p class="card-text">{{ $commentCount }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection