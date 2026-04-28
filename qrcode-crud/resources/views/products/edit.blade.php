@extends('layouts.app')
@section('content')
    <h4>Edit Product</h4>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" value="{{ $product->name }}"></div>
        <div class="mb-3"><label>Price</label><input type="text" name="price" class="form-control" value="{{ $product->price }}"></div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection