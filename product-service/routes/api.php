
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SlideshowController;


Route::middleware('verify.token')->group(function () {
    Route::apiResource("categories", CategoryController::class);
    Route::apiResource("products", ProductController::class);
    Route::get('gets', [ProductController::class, 'get']); 
    Route::apiResource("slideshows", SlideshowController::class);
});



