<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Follow;
use App\Models\User;
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

    // Создание нового поста 
    public function createPost(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:280',
        ]);

        $data = $request->only(['user_id', 'message']); // извлечение нужных полей
        $hastagsAndMentions = extract_mentions_and_hashtags($data['message']); // извлечение отметок, хэштегов из сообщения

        $post = $this->postService->createPost($data); // Создание поста

        store_mentions_and_hashtags($hastagsAndMentions, $post->id);  // Сохраняем упоминания и хэштеги 

        return response()->json($post);  // Возвращаем созданный пост
    }

    // Полученине постов для своей ленты
    public function getLenta()
    {
        $current_user_id = 3; // ID текущего пользователя (чью ленту показывать?)

        $ownAndMentionedPosts = $this->postService->getPostsByUserIdAndMention($current_user_id); // Получаем посты по user_id и упоминаниям
        $followedPosts = $this->postService->getPostsByFollowing($current_user_id); // Получаем посты от пользователей, на которых подписан текущий пользователь

        $allPosts = merge_and_sort_posts($ownAndMentionedPosts, $followedPosts); // Объединяем оба массива постов

        $sortedPosts = filter_and_sort_posts($allPosts, 30); // Ограничиваем кол-во и сортируем по дате

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
        $current_user_id = 3; // ID текущего пользователя (чьи подписки смотреть?)

        $user = User::where('nickname', $nickname)->first(); // нахождение пользователя по nickname

        if (!$user) { // проверка, что пользователь существует
            return response()->json(['error' => 'User not found']);
        }

        $postsByUserIdAndMention = $this->postService->getPostsByUserIdAndMention($user->id, $current_user_id);  // получение постов по user_id и упоминания этого user-a

        return response()->json($postsByUserIdAndMention->values()->toArray()); // обнуление и приведение к array
    }

    // Получение постов по подписке (На кого подписан пользователь - тех пользователей посты и получаем)
    public function getPostsByFollow()
    {
        $current_user_id = 3;

        $user = User::find($current_user_id); // Получаю пользователя с id === 3

        $followedUsers = $user->following;  // Получение всех пользователей, на которых подписан текущий пользователь
        $posts = Post::whereIn('user_id', $followedUsers->pluck('id'))->get(); // Получаем все посты от этих пользователей

        return response()->json($posts);
    }
}
