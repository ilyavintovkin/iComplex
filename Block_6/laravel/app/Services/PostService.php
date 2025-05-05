<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Log;

class PostService
{
    // Создание нового поста
    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    // Получение постов по user_id
    public function getPostsByUserId(int $userId = 1) 
    {
        $query = Post::where('user_id', $userId); // получение постов по определенному userId 

        return get_recent_posts($query, ['user']); // ворачивание отсортированных постов с ограничением на кол-во постов
    }

    // Получение постов по отметкам ( @tim )
    public function getPostsByMention(int $mentionedUserId)
    {
        $query = Post::whereHas('mentions', function ($q) use ($mentionedUserId) { // фильтрует посты, у которых есть связь mentions
            $q->where('mentioned_user_id', $mentionedUserId); // выбираются только те, где упомянут конкретный пользователь.
        });
    
        return get_recent_posts($query, ['user', 'mentions']); // ворачивание отсортированных постов с ограничением на кол-во постов
    }

    // Получение постов по хэштегам ( #friends )
    public function getPostsByHashtag(string $tagName)
    {
        $query = Post::whereHas('hashtags', function ($q) use ($tagName) { // фильтрует посты, у которых есть связь hashtags
            $q->where('name', $tagName); // выбираются только содержащие конкретный хэштег $tagName
        });
        
        return get_recent_posts($query, ['user', 'hashtags']); // ворачивание отсортированных постов с ограничением на кол-во постов
    }

    // Получение постов по user_id ( 1 ) и отметкам ( @tim )
    public function getPostsByUserIdAndMention(int $user_id) 
    {
        $ownPosts = $this->getPostsByUserId($user_id); // отдельное получение постов по user_id
        $mentionedPosts = $this->getPostsByMention($user_id); // отдельное получение постов по отметкам ( @tim )

        $mergedPosts = merge_and_sort_posts($ownPosts, $mentionedPosts); // обьединение постов по user_id и отметкам. 

        return $mergedPosts;
    }
}
