<?php

use App\Http\Controllers\Api\ActeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DocController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// ------------ Public Routes ------------ //
Route::get('/', function () {
    return response()->json(["response" => "api home page"]);
});
// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get("/seed", function () {
    try {
        Artisan::call("migrate:fresh --seed");
        return response()->json(["status" => "done"]);
    } catch (\Exception $e) {
        return response()->json(["status" => "failed", "error" => $e->getMessage()]);
    }
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated routes
    Route::post("/password", [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('actes', ActeController::class);
    Route::apiResource('docs', DocController::class);
    Route::apiResource('users', UserController::class);
});


Route::fallback(function () {
    return response()->json(['message' => 'API endpoint not found'], 404);
});
