<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models;
use App\Models\Hashtag;
use App\Models\PostHashtag;
use App\Models\Mention;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    // создание нового поста
    public function createPost(Request $request)
    {
        $data = $request->only(['user_id', 'message']); // Извлекаем нужные поля
        $hastagsAndMentions = $this->extractMentionsAndHashtags($data['message']);

        // Создаём пост
        $post = $this->postService->createPost($data);

        // После создания поста, сохраняем упоминания и хэштеги
        $this->storeMentions($hastagsAndMentions['mentions'], $post->id);  // Сохраняем упоминания
        $this->storeHashtags($hastagsAndMentions['hashtags'], $post->id);  // Сохраняем хэштеги

        return response()->json($post);  // Возвращаем созданный пост
    }

    public function getLenta()
    {
        $userId = 1; // в будущем можно получать из авторизации

        // Получаем два набора постов
        $ownPosts = $this->postService->getPostsByUserId($userId);
        $mentionedPosts = $this->postService->getPostsByMention($userId);

        // Объединяем и удаляем дубликаты по ID постов
        $mergedPosts = $ownPosts->merge($mentionedPosts)->unique('id')->values();
        // Объединяем, удаляем дубликаты и сортируем по дате
        $mergedPosts = $ownPosts
            ->merge($mentionedPosts)
            ->unique('id')
            ->sortByDesc('created_at')
            ->values(); // сбрасываем ключи
            
        return response()->json($mergedPosts);
    }


    //_________________________________________________________________________
    public function extractMentionsAndHashtags(string $message): array
    {
        // Извлекаем @nickname
        preg_match_all('/@([\w\d_]+)/u', $message, $userMatches);
        $mentionedNicknames = $userMatches[1];

        // Извлекаем #hashtag
        preg_match_all('/#([\p{L}\d_]+)/u', $message, $tagMatches);
        $hashtags = $tagMatches[1];

        return [
            'mentions' => $mentionedNicknames,
            'hashtags' => $hashtags,
        ];
    }

    private function storeMentions(array $nicknames, int $postId): void
    {
        foreach ($nicknames as $nickname) {
            $user = User::where('nickname', $nickname)->first();
            if ($user) {
                Mention::create([
                    'post_id' => $postId,
                    'mentioned_user_id' => $user->id,
                ]);
            }
        }
    }

    private function storeHashtags(array $tagNames, int $postId): void
    {
        foreach ($tagNames as $tagName) {
            $hashtag = Hashtag::firstOrCreate(['name' => $tagName]);
            PostHashtag::create([
                'post_id' => $postId,
                'hashtag_id' => $hashtag->id,
            ]);
        }
    }

    public function getPostsByHashtag(string $tag)
    {
        $posts = $this->postService->getPostsByHashtag($tag);

        return response()->json($posts);
    }
    public function getPostsByUserNickname(string $nickname)
    {
        Log::info('Поиск по нику: ' . $nickname);

        $user = User::where('nickname', $nickname)->first();

        if (!$user) {
            Log::warning("Пользователь не найден: $nickname");
            return response()->json(['error' => 'User not found'], 404);
        }

        Log::info("Найден пользователь: " . $user->id);

        $ownPosts = $this->postService->getPostsByUserId($user->id);
        $mentionedPosts = $this->postService->getPostsByMention($user->id);

        $mergedPosts = $ownPosts->merge($mentionedPosts)->unique('id')->values();

        return response()->json($mergedPosts);
    }
}
