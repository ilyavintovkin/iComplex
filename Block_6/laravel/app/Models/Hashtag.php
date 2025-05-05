<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name']; // указание какие поля можно заполнять массово

    public $timestamps = true;  // Указываем, что таблица содержит временные метки (created_at, updated_at)

    // Описывает отношениt многие ко многим (Many-to-Many)  между хэштегами и постами
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_hashtag', 'hashtag_id', 'post_id'); 
    }//  2 - указание промежуточной  таблицы, 3 - внешний ключ на текущую модель (Hashtag), 4 - внешний ключ на связанную модель (Post)
}
