<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['user_id', 'message']; // указание какие поля можно заполнять массово

    // Эта функция определяет связь "Один к Многим" между моделями Post и User
    public function user()
    {
        return $this->belongsTo(User::class); // один пост принадлежит одному польователю (автору)
    }

    public function mentions()
    {
        return $this->hasMany(Mention::class); // один пост может иметь несколько отметок
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'post_hashtag'); // один пост может принадлежать множеству хэштегов, указание таблицы
    }
}
