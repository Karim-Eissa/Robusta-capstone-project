<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/token', function () {
    return csrf_token(); 
});

