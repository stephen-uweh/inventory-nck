<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InventoryController;
use App\Models\Inventory;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth Routes
Route::group(["prefix" => "auth"], function () {
    Route::post("/login", [AuthenticationController::class, 'login']);
    Route::post("/register", [AuthenticationController::class, 'register']);
});



// JWT Protected Routes
Route::group(["middleware" => "auth"], function () {

    // Inventory Routes
    
    Route::group(["prefix" => "/inventory"], function () {
        Route::get("/all", [InventoryController::class, 'index']);
        Route::get("/{id}", [InventoryController::class, 'show']);
        Route::post("/add", [InventoryController::class, 'create']);
        Route::put("/edit/{id}", [InventoryController::class, 'edit']);
        Route::delete("/delete/{id}", [InventoryController::class, 'delete']);
    });

    // Cart Routes

    Route::group(["prefix" => "cart"], function () {
        Route::get('/', [CartController::class, 'show']);
        Route::post('/add', [CartController::class, 'addToCart']);
        Route::post('/remove', [CartController::class, 'removeFromCart']);
        Route::post('/clear', [CartController::class, 'clearCart']);
    });

});

Route::get('/test', function(){
    return "API";
});


// Redirect for login route
Route::get('/log', function(){
    return response()->json([
        "message" => "Incorrect credentials"
    ], 401);
})->name('login');


