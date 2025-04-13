<?php
namespace App\Services;

use App\Models\Post;

class PostService
{
    public function getPosts() {
        return Post::latest()->get();
    }
    public function createPost($author, $message)
    {
        return Post::create([
            'author' => $author,
            'message' => $message,
        ]);
    }
}
