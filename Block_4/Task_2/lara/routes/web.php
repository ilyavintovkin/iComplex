<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/posts', [PostController::class, 'index']);

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::get('/posts/updated', [PostController::class, 'updated']);

Route::delete('/posts/{id}', [PostController::class, 'delete']);
