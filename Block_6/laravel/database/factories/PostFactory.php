<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    // Указываем модель, для которой создаем фабрику
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            // user_id оставляем null, чтобы назначить его в сидере
            'user_id' => null, 
            // Генерация случайного контента (можно использовать sentence или текст произвольной длины)
            'content' => $this->faker->sentence(10), // 10 слов в предложении
            // Время создания поста
            'created_at' => now(),
            // Время обновления поста (по умолчанию совпадает с created_at)
            'updated_at' => now(),
        ];
    }
}
