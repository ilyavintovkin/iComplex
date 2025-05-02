<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAllPosts()
    {
        // Получаем все посты из базы данных
        $posts = Post::all();

        // Возвращаем их в виде JSON
        return response()->json($posts);
    }
}
