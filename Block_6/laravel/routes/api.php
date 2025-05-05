<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
// тестовый маршрут, для проверки.
Route::get('/hello', function () {  return response()->json(['message' => 'Hello from Laravel']);});
  
// главная страница
Route::get('/lenta',      [PostController::class, 'getLenta']);
// создание нового поста
Route::post('/newPost',   [PostController::class, 'createPost']);
// поиск постов по хэштегу ( friends )
Route::get('/hash/{tag}', [PostController::class, 'getPostsByHashtag']);
// поиск постов по никнейму ( sam )
Route::get('/{nickname}', [PostController::class, 'getPostsByUserNickname']);


