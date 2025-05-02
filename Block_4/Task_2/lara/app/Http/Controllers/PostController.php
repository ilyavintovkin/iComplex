<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    // Показать все посты
    public function index()
    {
        $posts = $this->postService->getPosts();
        return view('posts', compact('posts'));
    }

    // Сохранить новый пост
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required|string|max:100',
            'message' => 'required|string',
        ]);

        $this->postService->createPost($request->author, $request->message);

        return redirect()->back()->with('success', 'Пост добавлен!');
    }

    public function delete($id) {
        
        $post = Post::findOrFail($id);
        $post->delete();
    
        return response()->json(['message' => 'Пост удалён']);
    }

    public function Updated()    
    {
        $posts = $this->postService->getPosts();
        return view('updated', compact('posts'));
    }
}
