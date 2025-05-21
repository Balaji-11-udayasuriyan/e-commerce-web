@extends('layouts.layout')

@section('title', 'Your Cart')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">🛒 Your Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    @if($carts->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($carts as $row)
                    @php
                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $row['name'] }}</td>
                        <td>${{ number_format($row['price'], 2) }}</td>
                        <td class="d-flex align-items-center gap-2">
                        
                            <form action="{{ url('/decrease-quantity') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $row['id'] }}">
                                <button type="submit" class="btn btn-sm btn-secondary">-</button>
                            </form>

                            <span>{{ $row['quantity'] }}</span>

                            <form action="{{ url('/increase-quantity') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $row['id'] }}">
                                <button type="submit" class="btn btn-sm btn-secondary">+</button>
                            </form>
                        </td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ url('/remove-from-cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" value="{{ $row['id'] }}">
                                <button onclick="return confirm('Remove this item?')" type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <!-- Clear Cart Button -->
            <form action="{{ url('/clear-cart') }}" method="POST">
                @csrf
                <button onclick="return confirm('Clear entire cart?')" type="submit" class="btn btn-warning">
                    🧹 Clear Cart
                </button>
            </form>

            <form action="{{ route('order.confirm') }}" method="GET">
                <button type="submit" class="btn btn-success">
                    🛍️ Proceed to Buy
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
