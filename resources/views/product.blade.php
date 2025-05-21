@extends('layouts.layout')

@section('title', 'Available Products')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">📦 Available Products</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="alert alert-warning text-center">
            No products available with more than 10 stock.
        </div>
    @else
        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <table class="table table-bordered table-hover shadow">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Add to Cart</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->stock }}</td>
                                <td>
                                    <form action="{{ url('/add-to-cart') }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $row->id }}">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $row->stock }}" class="form-control form-control-sm" style="width: 80px;">
                                        <button type="submit" class="btn btn-success btn-sm">Add 🛒</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
