<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Test route
Route::get('/test', function (Request $request) {
    return response()->json(['message' => 'API is working']);
}); 

// get all products 

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
// get a single product by id
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show']);
// create a new product             
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store']);
// update a product by id
Route::put('/products/{id}', [App\Http\Controllers\ProductController::class, 'update']);
// delete a product by id
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

Route::get('/test-simple', function() {
    try {
        // Create products table if it doesn't exist
        if (!Schema::hasTable('products')) {
            Schema::create('products', function ($table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->string('image_url')->nullable();
                $table->integer('stock');
                $table->timestamps();
            });
        }
        
        // Insert a test product
        DB::table('products')->insert([
            'name' => 'Test Product',
            'price' => 19.99,
            'stock' => 10,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Get products
        $products = DB::table('products')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Test completed',
            'products' => $products
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
