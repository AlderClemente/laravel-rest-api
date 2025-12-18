<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Your existing routes here (if any)...

// Add this test route:
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
            echo "Created products table<br>";
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