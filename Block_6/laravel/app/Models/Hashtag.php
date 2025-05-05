<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name'];  // Указываем, какие поля можно заполнять

    public $timestamps = true;  // Указываем, что таблица содержит временные метки (created_at, updated_at)

    // Пример метода для получения постов с данным хэштегом
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_hashtag', 'hashtag_id', 'post_id');
    }
}
