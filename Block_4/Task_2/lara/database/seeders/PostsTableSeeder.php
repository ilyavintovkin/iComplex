<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Вставка данных в таблицу posts
        DB::table('posts')->insert([
            [
                'author' => 'Александр Пушкин',
                'message' => 'Я вас любил: любовь еще, быть может, в душе моей угасла не совсем',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'author' => 'Анна Ахматова',
                'message' => 'Мы знаем что ныне лежит на весах и что совершается ныне',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
