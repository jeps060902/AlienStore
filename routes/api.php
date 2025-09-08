<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SecRoleController;
use App\Http\Controllers\Admin\SecUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubcategoryController;

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

    Route::apiResource('/Role', SecRoleController::class);
    Route::apiResource('/User', SecUserController::class);
    Route::apiResource('products', ProductController::class);
Route::apiResource('categories', ProductCategoryController::class);
Route::apiResource('subcategories', ProductSubcategoryController::class);
});

Route::post('/Register', [AuthController::class, 'Register']);
Route::post('/Login', [AuthController::class, 'Login']);
Route::middleware('auth:api')->get('/check-token', function () {
    return response()->json(auth()->guard('api')->user());
});
