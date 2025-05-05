<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    // Создание нового поста 
    public function createPost(Request $request)
    {
        $data = $request->only(['user_id', 'message']); // извлечение нужных полей
        $hastagsAndMentions = extract_mentions_and_hashtags($data['message']); // извлечение отметок, хэштегов из сообщения

        $post = $this->postService->createPost($data); // Создание поста

        store_mentions_and_hashtags($hastagsAndMentions, $post->id);  // Сохраняем упоминания и хэштеги 

        return response()->json($post);  // Возвращаем созданный пост
    }

    // Метод отображающий ленту текущего пользователя
    public function getLenta()
    {
        $userId = 2; // ID пользователя (для кого будет отображена лента)
    
        $ownAndMentionedPosts = $this->postService->getPostsByUserIdAndMention($userId); // получение постов по user_id и упоминания этого user-a
        $sortedPosts = filter_and_sort_posts($ownAndMentionedPosts, 5); // сортировка и ограничение кол-ва постов
    
        return response()->json($sortedPosts);
    }
    
    // Получение постов по хэштегу
    public function getPostsByHashtag(string $tag)
    {
        $posts = $this->postService->getPostsByHashtag($tag); // Получение постов по хэштегу

        return response()->json($posts);
    }

    // Получение постов по user->nickname
    public function getPostsByUserNickname(string $nickname)
    {
        $user = User::where('nickname', $nickname)->first(); // нахождение пользователя по nickname

        if (!$user) { // проверка, что пользователь существует
            return response()->json(['error' => 'User not found'], 404);
        }

        $postsByUserIdAndMention = $this->postService->getPostsByUserIdAndMention($user->id);  // получение постов по user_id и упоминания этого user-a

        return response()->json($postsByUserIdAndMention->values()->toArray()); // обнуление и приведение к array
    }
}
