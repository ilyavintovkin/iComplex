<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Заполняемые поля
    protected $fillable = ['user_id', 'message'];

    // Эта функция определяет связь "Один к Многим" между моделями Post и User
    public function user()
    {
        return $this->belongsTo(User::class);
        // $post = Post::find(1); 
        // $user = $post->user; к примеру могу получить user-а у поста
    }
    public function mentions()
    {
        return $this->hasMany(Mention::class);
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'post_hashtag');
    }
}
