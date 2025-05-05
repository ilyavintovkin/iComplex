<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    protected $table = 'post_hashtag'; // указание таблицы, с которой будет работать данная модель
    
    protected $fillable = ['post_id', 'hashtag_id']; // указание какие поля можно заполнять массово

    public $timestamps = false; //  отмена автоматичесого назначение created_at, updated_at
}