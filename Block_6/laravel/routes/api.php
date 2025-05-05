<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
// тестовый маршрут, для проверки.
Route::get('/hello', function () {  return response()->json(['message' => 'Hello from Laravel']);});
  
// *посты user-ов на кого мы подписаны, посты этого user-a, посты где этого user-a отметили @sam
Route::get('/lenta',      [PostController::class, 'getLenta']);
// создание нового поста
Route::post('/newPost',   [PostController::class, 'createPost']);
// поиск постов по хэштегу ( friends ) *посты, где есть этот хэштег
Route::get('/hash/{tag}', [PostController::class, 'getPostsByHashtag']); // x
// поиск постов по никнейму ( sam ) *посты этого user-a, посты где этого user-a отметили @sam
Route::get('/{nickname}', [PostController::class, 'getPostsByUserNickname']);


