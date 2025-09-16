<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// // "php": "^8.0.2", composer install --ignore-platform-reqs
Route::post('/register', [AuthController::class, 'Register']);
 
Route::post('/loginn', [AuthController::class, 'loginn']);
Route::get('/test',function (Request $request) {
    print('testr');
});

    
 Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel API']);
});
 
Route::post('/hello', function (Request $request) {
    return response()->json([
        'message' => 'Hello POST received!',
        'data' => $request->all()
    ]);
});

Route::get('/images', [ImageController::class, 'getImages']);