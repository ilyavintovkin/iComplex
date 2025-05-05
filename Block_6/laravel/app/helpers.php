<?php

use App\Models\User;
use App\Models\Mention;
use App\Models\Hashtag;
use App\Models\PostHashtag;

// Извлекает из сообщения @никнеймы и #хэштеги
if (!function_exists('extract_mentions_and_hashtags')) { // проверка на переопределение функции 

    function extract_mentions_and_hashtags(string $message): array
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

// Создает новую Mention (Отметку)
if (!function_exists('store_mentions')) {

    function store_mentions(array $nicknames, int $postId): void
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
}

// Создает новый или находит старый Hashtag. Создает PostHashtag 
if (!function_exists('store_hashtags')) {

    function store_hashtags(array $tagNames, int $postId): void
    {
        foreach ($tagNames as $tagName) { // проходит по каждому #хэштегу 
            $hashtag = Hashtag::firstOrCreate(['name' => $tagName]); // получает или создает новый #хэштег
            PostHashtag::create([ // создание Записи Пост-Хэштег
                'post_id' => $postId, // указывается Id поста
                'hashtag_id' => $hashtag->id, // указывается Id хэштега
            ]);
        }
    }
}

// Обьединяющий метод для store_hashtags и store_mentions
if (!function_exists('store_mentions_and_hashtags')) {

    function store_mentions_and_hashtags(array $tagAndMention, int $postId): void
    {
        store_mentions($tagAndMention['mentions'],  $postId); // Создает новую Mention (Отметку)
        store_hashtags($tagAndMention['hashtags'],  $postId); // Создает новый или находит старый Hashtag. Создает PostHashtag 
    }
}

// Принимает запрос Query
if (!function_exists('get_recent_posts')) {

    function get_recent_posts($query, array $with = ['user'], int $limit = 5)
    {
        return $query->with($with)
            ->orderBy('created_at', 'desc') // сортировка по убыванию даты создания
            ->take($limit)                  // ограничение количества получаемых постов
            ->get();                        // выполнение запроса и получение коллекции
    }
}

// Принимает коллекцию
if (!function_exists('filter_and_sort_posts')) {
    
    function filter_and_sort_posts($posts, int $limit = 5)
    {
        return $posts
            ->unique('id') // чтобы не было дубликатов по id
            ->sortByDesc('created_at') // сортировка по дате создания в убывающем порядке
            ->take($limit); // ограничение на количество постов
    }
}

// Принимает две коллекции и обьединяет их
if (!function_exists('merge_and_sort_posts')) {

    function merge_and_sort_posts($collection1, $collection2, int $limit = 5)
    {
        return $collection1
            ->merge($collection2)         // объединяем коллекции $collection1, $collection2
            ->unique('id')                 // удаление дубликатов по id
            ->sortByDesc('created_at')     // сортируем по убыванию даты
            ->take($limit);                // ограничиваем количеством постов
    }
}