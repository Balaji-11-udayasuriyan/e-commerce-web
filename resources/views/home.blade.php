@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">

        <h2 class="text-center mb-4">📦 Products with More Than 10 in Stock</h2>
        @include('product')

        <h2 class="text-center mb-4">🧾 Your Orders</h2>
        @include('myorder')

    </div>
@endsection
