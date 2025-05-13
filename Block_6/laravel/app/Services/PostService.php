<?php

namespace App\Services;

use App\Models\Follow;
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
    public function getPostsByUserId(int $userId = 3)
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
        $current_user_id = 3; // id текущего пользователя (кто делает запрос найти посты по хэштегу?)

        // Получение постов по хэштегу
        $query = Post::whereHas('hashtags', function ($q) use ($tagName) {
            $q->where('name', $tagName); // выбираются только посты с конкретным хэштегом
        });

        // Получаем отсортированные посты с авторами и хэштегами
        $posts = get_recent_posts($query, ['user', 'hashtags']);

        // Получаем ID пользователей, на которых подписан текущий пользователь
        $followingIds = Follow::where('follower_id', $current_user_id)
            ->pluck('followed_id') // извлекается одно конкретное поле followed_id
            ->toArray();

        // Добавляем поле is_following
        $posts->each(function ($post) use ($followingIds) { // перебор каждого поста 
            $post->is_following = in_array($post->user_id, $followingIds); // если пост от пользователя, на которого подписан текущий пользователь, ставим true
        });

        return $posts;
    }

    public function getPostsByFollowing(int $currentUserId = 3)
    {
        // Получаем ID пользователей, на которых подписан текущий пользователь
        $followingIds = Follow::where('follower_id', $currentUserId)
            ->pluck('followed_id') // получение конкретного поля
            ->toArray();

        $query = Post::whereIn('user_id', $followingIds); // Получаем посты этих пользователей
        $posts = get_recent_posts($query, ['user']); // Получаем отсортированные посты с авторами


        $posts->each(function ($post) {
            $post->is_following = true; // добавляем поле is_following == true. Так как это посты пользователей, на которых мы подписаны
        });

        return $posts; // возвращаем отсортированные посты с авторами
    }

    // Получение постов по user_id ( 1 ) и отметкам ( @tim )
    public function getPostsByUserIdAndMention(int $user_id, int $currentUserId = 3)
    {
        $ownPosts = $this->getPostsByUserId($user_id); // отдельное получение постов по user_id
        $mentionedPosts = $this->getPostsByMention($user_id); // отдельное получение постов по отметкам ( @tim )
        $mergedPosts = merge_and_sort_posts($ownPosts, $mentionedPosts); // обьединение постов по user_id и отметкам. 

        $followingIds = Follow::where('follower_id', $currentUserId) // получение ID пользователей, на которых подписан текущий пользователь
            ->pluck('followed_id') // берем только поле "followed_id"
            ->toArray();


        $mergedPosts->each(function ($post) use ($followingIds) { // перебор каждого поста
            $post->is_following = in_array($post->user_id, $followingIds); // добавляем поле is_following (если true - значит мы подписаны на автора поста)
        });

        return $mergedPosts;
    }
}
