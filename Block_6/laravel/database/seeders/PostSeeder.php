<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем всех пользователей
        $users = User::all();

        // Если нет пользователей, то завершить выполнение
        if ($users->isEmpty()) {
            return;
        }

        // Для каждого пользователя создаем 3 поста
        foreach ($users as $user) {
            Post::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
