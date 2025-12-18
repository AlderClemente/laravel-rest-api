<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No products found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }

    // Get a single product using route model binding
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric', // 'decimal:2' works for Laravel 9+
            'image_url' => 'nullable|string',
            'stock'=> 'required|integer'
        ]);

        $product = Product::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201); // 201 = Created
    }

    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|string',
            'stock'=> 'required|integer'
        ]);

        $product->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
