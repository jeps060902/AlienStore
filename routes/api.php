<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SecRoleController;
use App\Http\Controllers\Admin\SecUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubcategoryController;
use App\Http\Controllers\ProductDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:api'])->group(function () {

    Route::apiResource('/role', SecRoleController::class);
    Route::apiResource('/user', SecUserController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('products-detail', ProductDetailController::class);
Route::apiResource('categories', ProductCategoryController::class);
Route::apiResource('subcategories', ProductSubcategoryController::class);
});

Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);
