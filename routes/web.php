<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MahaController;
use App\Http\Controllers\BukuController;

Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about', [
        'name' => 'Ruhil M.U',
        'email' => '-@gmail.com'
    ]);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/mahasiswa', [MahaController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/search', [BukuController::class, 'search'])->name('search');
    Route::get('/buku/{id}/detail', [BukuController::class, 'show'])->name('detail');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('create');
        Route::post('/buku', [BukuController::class, 'store'])->name('store');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('destroy');
        Route::delete('/buku/{id}/gallery/{gallery_id}', [BukuController::class, 'destroyGallery'])->name('destroyGallery');
        Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::post('/buku/{id}', [BukuController::class, 'update'])->name('update');

    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// use App\Http\Controllers\Auth\LoginRegisterController;
// Route::controller(LoginRegisterController::class)->group(function() {
//  Route::get('/register', 'register')->name('register');
//  Route::post('/store', 'store')->name('store');
//  Route::get('/login', 'login')->name('login');
//  Route::post('/authenticate', 'authenticate')->name('authenticate');
//  Route::get('/dashboard', 'dashboard')->name('dashboard');
//  Route::post('/logout', 'logout')->name('logout');
// });