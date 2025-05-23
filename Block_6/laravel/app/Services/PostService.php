<?php

namespace App\Services;

use App\Models\User;
use App\Models\Mention;
use App\Models\Hashtag;
use App\Models\PostHashtag;
use App\Tmp\CurrentUser;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostService extends CurrentUser
{

    // Методы получения постов по определенному признаку

    public function createPost(Request $request): Post // Создание нового поста
    {
        $data = $request->only(['user_id', 'message']); // извлечение нужных полей
        $hastagsAndMentions = $this->extractMentionsAndHashtags($data['message']); // извлечение отметок, хэштегов из сообщения

        $post = Post::create($data); // Создание поста
        $this->storeMentionsAndHashtags($hastagsAndMentions, $post->id);  // Сохраняем упоминания и хэштеги 

        return $post;
    }

    public function getByUserId(int $currentUserId, int $userId): Collection // посты по userId
    {
        return Post::with('user') // Беру посты и подгружабю автора каждого поста
            ->leftJoin('follows', function ($join) use ($currentUserId, $userId) { // присоединенеие таблицы follows к таблице posts
                $join->on('posts.user_id', '=', 'follows.followed_id') // связываем посты и подписки так, что user_id (автор поста) должен совпадать с followed_id (человек, на которого подписались).
                    ->where('follows.follower_id', '=', $currentUserId); // уточнение: интересуют подписки, где подписчик — текущий пользователь $currentUser.
            })
            ->where('posts.user_id', $userId) // берутся посты, id автора которых === $userId
            ->orderBy('posts.created_at', 'desc') // сортировка по created_at (свежие)
            ->select('posts.*', DB::raw('IF(follows.id IS NULL, false, true) as is_following')) // Добавляем дополнительное вычисляемое поле is_following
            ->limit(10)
            ->get(); // Выполняем запрос к базе, получаем коллекцию постов с нужными полями.
    }

    public function getByHashtag(int $currentUserId, string $hashtag): Collection // посты по хэштегу
    {
        return Post::with('user')
            ->leftJoin('follows', function ($join) use ($currentUserId) {
                $join->on('posts.user_id', '=', 'follows.followed_id')
                    ->where('follows.follower_id', '=', $currentUserId);
            })
            ->whereHas('hashtags', function ($query) use ($hashtag) {
                $query->where('name', $hashtag);
            })
            ->orderBy('posts.created_at', 'desc')
            ->select('posts.*', DB::raw('IF(follows.id IS NULL, false, true) as is_following'))
            ->limit(10)
            ->get();
    }

    public function getByNickname(int $currentUserId, string $nickname): Collection // посты по никнейму
    {
        return Post::with('user')
            ->leftJoin('follows', function ($join) use ($currentUserId) {
                $join->on('posts.user_id', '=', 'follows.followed_id')
                    ->where('follows.follower_id', '=', $currentUserId);
            })
            ->whereHas('mentions.mentionedUser', function ($query) use ($nickname) {
                $query->where('nickname', $nickname);
            })
            ->orderBy('posts.created_at', 'desc')
            ->select('posts.*', DB::raw('IF(follows.id IS NULL, false, true) as is_following'))
            ->limit(10)
            ->get();
    }

    public function getByMentioned(int $userId): Collection // посты по отметке
    {
        return Post::with('user')
            ->whereHas('mentions', function ($query) use ($userId) {
                $query->where('mentioned_user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBySubscriptions(int $userId): Collection // посты по подписке
    {
        return Post::with('user')
            ->whereIn('user_id', function ($query) use ($userId) {
                $query->select('followed_id')
                    ->from('follows')
                    ->where('follower_id', $userId);
            })
            ->get();
    }

    public function getMixedPosts(int $currentUserId)
    {
        return Post::with('user') // получаю посты со связью пользователь
            ->leftJoin('mentions', 'posts.id', '=', 'mentions.post_id') // подключаем упоминания, чтобы проверить, упомянут ли пользователь
            ->leftJoin('follows', function ($join) use ($currentUserId) { // подключаем подписки, чтобы понять, подписан ли пользователь на автора
                $join->on('posts.user_id', '=', 'follows.followed_id') // автор поста = тот, на кого подписаны
                    ->where('follows.follower_id', '=', $currentUserId); // только если подписчиком является текущий пользователь
            })
            ->where(function ($query) use ($currentUserId) {
                $query->where('posts.user_id', $currentUserId) // пост написал текущий пользователь
                    ->orWhere('mentions.mentioned_user_id', $currentUserId) // или текущий пользователь упомянут
                    ->orWhere('follows.follower_id', $currentUserId); // или пользователь подписан на автора поста
            })
            ->select('posts.*', DB::raw("IF(follows.follower_id IS NULL, false, true) as is_following")) // добавляем поле: подписан ли пользователь на автора поста
            ->distinct()
            ->limit(10)
            ->orderBy('posts.created_at', 'desc')
            ->get();
    }

    // Методы работающие с хэштегами и отметками

    public function storeHashtags(array $tagNames, int $postId): void // сохранение хэштегов в бд
    {
        foreach ($tagNames as $tagName) { // проходит по каждому #хэштегу 
            $hashtag = Hashtag::firstOrCreate(['name' => $tagName]); // получает или создает новый #хэштег
            PostHashtag::create([ // создание Записи Пост-Хэштег
                'post_id' => $postId, // указывается Id поста
                'hashtag_id' => $hashtag->id, // указывается Id хэштега
            ]);
        }
    }

    public function storeMentions(array $nicknames, int $postId): void // сохранение отметок в бд
    {
        foreach ($nicknames as $nickname) {  // проходит по каждому @никнейму 
            $user = User::where('nickname', $nickname)->first(); // получает пользователя по никнейму
            if ($user) { // если такой пользователь существует
                Mention::create([ // создает Отметку
                    'post_id' => $postId, // Id поста 
                    'mentioned_user_id' => $user->id, // Id пользователя которого отметили в этом посте
                ]);
            }
        }
    }

    public function storeMentionsAndHashtags(array $tagAndMention, int $postId): void // сохранение отметок и хэштегов в бд
    {
        $this->storeMentions($tagAndMention['mentions'],  $postId); // Создает новую Mention (Отметку)
        $this->storeHashtags($tagAndMention['hashtags'],  $postId); // Создает новый или находит старый Hashtag. Создает PostHashtag 
    }

    public function extractMentionsAndHashtags(string $message): array // извлечение из строки отметок и хэштегов
    {
        // Извлекаем @nickname
        preg_match_all('/@([\w\d_]+)/u', $message, $userMatches); // ищет (по регулярке) @отметку в строке. Она сохраняет результат в массив $userMatches.
        $mentionedNicknames = $userMatches[1]; // присваивается только массив с никнеймами без @.

        // Извлекаем #hashtag
        preg_match_all('/#([\p{L}\d_]+)/u', $message, $tagMatches); // ищет (по регулярке) #хэштег в строке. Она сохраняет результат в массив $userMatches.
        $hashtags = $tagMatches[1];  // присваивается только массив с хэштегами без #.    

        return [
            'mentions' => $mentionedNicknames,
            'hashtags' => $hashtags,
        ];
    }
}
