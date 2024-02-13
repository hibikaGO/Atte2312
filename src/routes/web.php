<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VerificationController;
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
Route::middleware(['verified'])->group(function(){
    Route::get('/',[AttendanceController::class,'index']);
    Route::get('/attendance',[AttendanceController::class,'attendance']);
    Route::post('/record/start', [AttendanceController::class, 'start']);
    Route::post('/record/end', [AttendanceController::class, 'end']);
    Route::post('/record/break/start', [AttendanceController::class, 'startBreak']);
    Route::post('/record/break/end', [AttendanceController::class, 'endBreak']);
    Route::get('/users',[AttendanceController::class,'users']);
    Route::get('/personal/{id}', [AttendanceController::class, 'personal'])->name('personal');;
});

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.resend');
