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
}
