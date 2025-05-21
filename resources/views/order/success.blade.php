@extends('layouts.layout')

@section('title', 'Order Success')

@section('content')
<div class="container mt-5 text-center">
    <h2>🎉 Thank you for your order!</h2>
    <p>Your order has been placed successfully.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Continue Shopping</a>
</div>
@endsection
