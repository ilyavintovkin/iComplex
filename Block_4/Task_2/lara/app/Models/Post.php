<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [  'author',  'message', ];
    public $timestamps = true; // включаем обработку временных меток
}
