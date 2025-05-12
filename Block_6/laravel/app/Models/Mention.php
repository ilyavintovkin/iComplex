<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $fillable = ['post_id', 'mentioned_user_id']; // указание какие поля можно заполнять массово

    public $timestamps = false; // Указываем, что таблица НЕ содержит временные метки (created_at, updated_at) (Без автозаполнения)

    //  каждая отдельная строка в таблице mentions — это ОДНО упоминание одного пользователя в одном посте.
    public function post()
    {
        return $this->belongsTo(Post::class); // каждая отметка (Mention) принадлежит одному посту (Post)
    }

    public function mentionedUser()
    {
        return $this->belongsTo(User::class, 'mentioned_user_id'); // каждая отметка (Mention) принадлежит одному пользователю (User)
    } // 2 - внешний_ключ
}
