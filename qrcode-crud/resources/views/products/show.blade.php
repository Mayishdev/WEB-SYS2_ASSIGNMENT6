@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-header">Product Details & QR Code</div>
            <div class="card-body">
                <div class="mb-4">
                    {!! $qr !!} 
                </div>
                
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                
                <hr>

                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('products.saveQr', $product->id) }}" class="btn btn-success">
                        Save QR as PNG
                    </a>
                    
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection