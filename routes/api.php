<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::post("/login", [AuthController::class, "login"]);
// Route::post("/register", [AuthController::class, "register"]);
// Route::post("/password/reset", [AuthController::class, "reset"]);

Route::post('/login', [LoginController::class, 'login']);
// Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/password/reset', [ForgotPasswordController::class, 'sendResetLinkEmail']);

// ResetPasswordController ->reset;
