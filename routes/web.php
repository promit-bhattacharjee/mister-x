<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/user-registration',[UserController::class,"UserRegistration"]);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,"SendOtp"]);
Route::post("/verify-otp",[UserController::class,"VerifyOTP"]);
Route::middleware(TokenVerificationMiddleware::class)->group(
    function () {
        Route::post("/reset-password",[UserController::class,"ResetPassword"]);
    }
);