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

Route::get('/buku', [BukuController::class, 'index']);

Route::get('/buku/create', [BukuController::class, 'create'])->name('create');
Route::post('/buku', [BukuController::class, 'store'])->name('store');

Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('destroy');


Route::post('/buku/edit/{id}', [BukuController::class, 'edit'])->name('edit');
Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('update');

Route::get('/buku/search', [BukuController::class, 'search'])->name('search');
