<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

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


// api route


// user create and login route
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);


// User Logout
Route::get('/logout',[UserController::class,'UserLogout']);




// transaction route

Route::middleware([TokenVerificationMiddleware::class])->group(function () {

    Route::get('/transaction-show', [TransactionController::class, 'transactionShow']);
    Route::get('/deposit-show', [TransactionController::class, 'depositShow']);
    Route::post('/deposit',[TransactionController::class,'deposit']);
    Route::get('/withdrawal-show',[TransactionController::class,'withdrawalShow']);
    Route::post('/withdrawal',[TransactionController::class,'withdrawal']);

});