@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container mt-4">

  @if($comments->isEmpty())
  <div class="alert alert-info">No Commets found.</div>
  @else
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Comment</th>
          <th>Product Name</th>
          <th>User Name</th>
        </tr>
      </thead>
      <tbody>
        @forelse($comments as $comment)
        <tr>
          <td>{{ $comment->comment }}</td>
          <td>{{ $comment->product->name }}</td>
          <td>{{ $comment->user->name }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3">No comments available.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-end">
    {{ $comments->render('ui.custom_pagination') }}
  </div>
  @endif
</div>
@endsection