<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

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
})->name('login');
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
Route::post('/send-otp', [MailController::class, 'sendOtp'])->name('send-otp');

Route::get('/otp', function () {
    return view('otp');
})->name('otp');
Route::post('/check-otp', [MailController::class, 'checkOtp'])->name('check-otp');
Route::get('/logout', [MailController::class, 'logout'])->name('logout');
