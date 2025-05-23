<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Hashtag;
use App\Models\Mention;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $hashtags = Hashtag::all();

        if ($users->isEmpty()) {
            $this->command->error("Нет пользователей в базе данных!");
            return;
        }

        if ($hashtags->isEmpty()) {
            $this->command->warn("Нет хэштегов. Хэштеги не будут добавлены к постам.");
        }

        $allUserIds = $users->pluck('id')->all();
        $allNicknames = $users->pluck('nickname', 'id')->all();

        $batchSize = 500; // Можно менять, чтобы избежать переполнения памяти
        $totalPosts = 10;

        for ($i = 0; $i < $totalPosts; $i += $batchSize) {
            $postsBatch = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $authorId = $allUserIds[array_rand($allUserIds)];

                $mentionCount = rand(0, 2); // до 2 упоминаний
                $hashtagCount = rand(0, 3); // до 3 хэштегов

                $mentionedIds = collect($allUserIds)
                    ->filter(fn($id) => $id !== $authorId)
                    ->random($mentionCount)
                    ->all();

                $selectedHashtags = $hashtags->random(min($hashtagCount, $hashtags->count())) ?? [];

                $message = Str::random(rand(20, 100));

                // Добавим упоминания @nickname
                foreach ($mentionedIds as $uid) {
                    $message .= " @" . $allNicknames[$uid];
                }

                // Добавим хэштеги #tag
                foreach ($selectedHashtags as $hashtag) {
                    $message .= " #" . $hashtag->name;
                }

                $post = Post::create([
                    'user_id' => $authorId,
                    'message' => $message,
                ]);

                // Добавим упоминания в таблицу mentions
                foreach ($mentionedIds as $uid) {
                    Mention::create([
                        'post_id' => $post->id,
                        'mentioned_user_id' => $uid,
                    ]);
                }

                // Привяжем хэштеги
                if ($selectedHashtags instanceof \Illuminate\Support\Collection) {
                    $post->hashtags()->attach($selectedHashtags->pluck('id'));
                }
            }

            echo "Сгенерировано постов: " . ($i + $batchSize) . "\n";
        }

        echo "✅ Генерация " . $totalPosts . " постов завершена.\n";
    }
}
