<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'min:2'],
            'description' => ['required', 'min:5'],
            'price' => ['required'],
            'category_id' => ['required'],
            'stock' => ['required'],
            'image_url' => ['required', 'min:1'],
        ]);
        try {
            Product::create($validatedData);
            return response()->json(['message' => 'Product created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create product'], 500);
        }
    }
}
