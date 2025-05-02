<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel']);
});

Route::get('/getAllPosts', [PostController::class, 'getAllPosts']);