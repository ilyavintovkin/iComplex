<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Запрещаем массовое присваивание всех атрибутов по умолчанию
    protected $guarded = [];

    // Разрешаем массовое присваивание этих полей
    protected $fillable = ['user_id', 'text'];

    // Связь "пост принадлежит пользователю"
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
