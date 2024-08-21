<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {      
        $validatedData = $request->validate([
            'name' => ['required', 'min:2'],
            'description' => ['required', 'min:5'],
        ]);
        $validatedData['parent_id'] = $request->input('parent_id');
        try {
            Category::create($validatedData);
            return response()->json(['message' => 'Category created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category'], 500);
        }
    }
}
