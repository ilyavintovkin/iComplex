<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

// Контроллер постов
class PostController extends Controller
{
    private PostService $postService; // сервис постов

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function createPost(Request $request) // 1)UserId: 4   Message:[всем привет!] @отправить
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:280',
        ]);

        $newPost = $this->postService->createPost($request);
        return response()->json($newPost);  
    }

    public function getLenta()
    {
        $lentaPosts = $this->postService->getMixedPosts($this->current_user_id);
        return response()->json($lentaPosts);
    }

    public function getPostsByHashtag(string $tag)
    {
        $posts = $this->postService->getByHashtag($this->current_user_id, $tag); 
        return response()->json($posts);
    }

    public function getPostsByUserNickname(string $nickname)
    {
        $postsByUserIdAndMention = $this->postService->getByNickname($this->current_user_id, $nickname);  
        return response()->json($postsByUserIdAndMention->toArray()); 
    }
}
