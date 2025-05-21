@extends('layouts.layout')

@section('title', 'My Orders')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">🧾 Orders Placed by {{ auth()->user()->name }}</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-info text-center">
                You haven't placed any orders yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Placed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->id }}</td>
                                <td>₹{{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
