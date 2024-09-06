<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MahaController;

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
