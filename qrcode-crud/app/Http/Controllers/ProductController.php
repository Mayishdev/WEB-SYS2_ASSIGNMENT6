<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
   public function index(Request $request)
    {
       // Simply fetch all products
    $products = Product::all()->map(function ($product) {
        // Keep the QR code generation for the table
        $product->qr = QrCode::size(80)->generate(route('products.show', $product->id));
        return $product;
    });

    return view('products.index', compact('products'));
    }

    public function create() { return view('products.create'); }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'price' => 'required|numeric']);
        Product::create($request->all()); 
        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(Product $product) {
        // Encode all data into JSON for the QR code display
        $qr = QrCode::size(250)->generate(json_encode([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ]));
        return view('products.show', compact('product', 'qr'));
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $request->validate(['name' => 'required', 'price' => 'required|numeric']);
        $product->update($request->all()); 
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product) {
        $product->delete(); 
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    /**
     * Save the QR code as a PNG file using the GD library for Windows compatibility.
     */
    public function saveQrCode($id)
    {
        $product = Product::findOrFail($id);

    $folderPath = public_path('qrcodes');
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $fileName = 'product_' . $product->id . '.png';
    $fullPath = $folderPath . '/' . $fileName;

    // Revised syntax to avoid the BadMethodCallException
    // We use a try-catch to handle potential extension issues gracefully
    try {
        QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate(
                json_encode([
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price
                ]), 
                $fullPath 
            );
    } catch (\Exception $e) {
        // If PNG fails (usually due to Imagick), we fallback to SVG which always works
        $fileName = 'product_' . $product->id . '.svg';
        $fullPath = $folderPath . '/' . $fileName;
        QrCode::size(300)->generate(json_encode(['id' => $product->id]), $fullPath);
    }

    return back()->with('success', 'QR Code saved to public/qrcodes/' . $fileName);
    }
}

