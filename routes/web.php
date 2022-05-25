<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShortenUrlController;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');


    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Route::resource('shorten-url', ShortenUrlController::class);
    Route::get('/shorten-url', [ShortenUrlController::class, 'index'])->name('shorten-url.index');
    Route::post('/shorten-url', [ShortenUrlController::class, 'store'])->name('shorten-url.store');
    Route::put('/shorten-url', [ShortenUrlController::class, 'update'])->name('shorten-url.update');
    Route::get('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
Route::get('/{shorten_url}', [ShortenUrlController::class, 'show'])->name('shorten-url.show');
