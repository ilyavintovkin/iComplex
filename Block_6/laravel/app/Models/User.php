<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Заполняемые поля
    protected $fillable = ['nickname'];

    // Отношение с моделью Post (пользователь может иметь несколько постов)
    public function posts()
    { 
        return $this->hasMany(Post::class);
        // $user = User::find(1); 
        // $psot = $user->posts; к примеру могу получить массив постов, опредленного пользоватлея
    }
}
