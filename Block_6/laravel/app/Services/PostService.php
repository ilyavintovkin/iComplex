<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    // Создание нового поста
    public function createPost(array $data): Post
    {
        //Создает новый пост, автоматически подставляя поля $data в поля нового поста

        return Post::create($data);
    }

    // Получение постов по user_id
    public function getPostsByUserId(int $user_id = 1)
    {
        // вернуть посты, у которых поле [user_id] === $user_id

        return Post::with('user') // загружаем пользователя сразу
            ->where('user_id', $user_id)
            ->get();
    }

    public function getPostsByMention(int $mentionedUserId)
    {
        return Post::whereHas('mentions', function ($query) use ($mentionedUserId) {
            $query->where('mentioned_user_id', $mentionedUserId);
        })->with(['user', 'mentions'])->get();
    }

    public function getPostsByHashtag(string $tagName)
    {
        return Post::whereHas('hashtags', function ($query) use ($tagName) {
            $query->where('name', $tagName);
        })->with(['user', 'hashtags'])->get();
    }
}
