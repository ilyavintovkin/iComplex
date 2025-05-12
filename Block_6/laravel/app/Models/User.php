<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['nickname']; // указание какие поля можно заполнять массово

    public function posts()
    {
        return $this->hasMany(Post::class); // один пользователь может иметь несколько постов
    }
    // Связь с другими пользователями, на которых подписан текущий пользователь
    public function following()
    {
        // В этой строке создается связь многие ко многим между пользователями
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id'); // ... таблица, внешний ключ, внешний ключ
    }
}
