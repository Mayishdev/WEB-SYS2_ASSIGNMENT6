<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Store Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #f1f5f9;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            line-height: 1.6;
        }

        .store-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title h2 {
            font-weight: 700;
            margin: 0;
            color: var(--text-main);
        }

        .page-title p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.95rem;
        }

        .btn-add {
            background-color: var(--primary);
            color: white !important;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
            border: none;
        }

        .btn-add:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        }

        .inventory-card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            padding: 18px 25px;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 700;
        }

        .table tbody td {
            padding: 20px 25px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .qr-thumb {
            background: white;
            padding: 8px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .qr-thumb:hover {
            transform: scale(1.1);
            border-color: var(--primary);
        }

        /* Updated Philippine Price Tag Styling */
        .price-tag {
            font-weight: 700;
            color: #059669; /* Emerald Green */
            background: #ecfdf5;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-view { background: #eff6ff; color: #2563eb !important; }
        .btn-view:hover { background: #dbeafe; }

        .btn-edit { background: #fffbeb; color: #d97706 !important; }
        .btn-edit:hover { background: #fef3c7; }

        .btn-delete { background: #fef2f2; color: #dc2626 !important; border: none; cursor: pointer; }
        .btn-delete:hover { background: #fee2e2; }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="store-container">
        <div class="page-header">
            <div class="page-title">
                <h2>Product Inventory</h2>
                <p>Manage items and QR codes (PHP Currency)</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn-add">
                + Add New Product
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="inventory-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>QR Asset</th>
                        <th>Product Info</th>
                        <th>Pricing (PHP)</th>
                        <th style="text-align: right;">Management</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="qr-thumb">
                                {!! $product->qr !!}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; font-size: 1.05rem;">{{ $product->name }}</div>
                            <div style="color: #64748b; font-size: 0.85rem;">SKU: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                            <span class="price-tag">₱ {{ number_format($product->price, 2) }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-action btn-view">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-action btn-edit">Edit</a>
                                
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
</body>
</html>