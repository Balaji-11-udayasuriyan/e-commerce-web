@extends('layouts.layout')

@section('title', 'Confirm Order')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">🧾 Order Summary</h2>

    @php $total = 0; @endphp

    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems && count($cartItems) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    @php
                        $subtotal = $item->product->price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('order.place') }}" method="POST">
            @csrf
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('carts') }}" class="btn btn-secondary">
                    ← Back to Cart
                </a>
                <button type="submit" class="btn btn-success">
                    ✅ Confirm & Place Order
                </button>
            </div>
        </form>
    @else
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="{{ url('/') }}" class="btn btn-primary">🛍️ Shop Now</a>
    @endif
</div>
@endsection
