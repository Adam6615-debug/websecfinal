@extends('layouts.master')

@section('title', 'Orders')

@section('content')
<div class="row justify-content-between align-items-center mt-4 mb-3">
  <div class="col-md-6">
    <h2 class="fw-bold">Orders</h2>
  </div>
</div>

<form>
  <div class="row g-2 mb-3">
    <div class="col-sm-3">
      <input name="keywords" type="text" class="form-control" placeholder="Search Orders" value="{{ request()->keywords }}" />
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
    <div class="col-auto">
      <a href="{{ route('orders') }}" class="btn btn-sm btn-danger">Reset</a>
    </div>
  </div>
</form>

<div class="card shadow-sm">
  <div class="card-body">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Order ID</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        <tr>
          <td>{{ $order->id }}</td>
          <td>{{ $order->product->name }}</td>
          <td>{{ $order->quantity }}</td>
          <td>${{ number_format($order->total, 2) }}</td>
          <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-muted">No orders found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
