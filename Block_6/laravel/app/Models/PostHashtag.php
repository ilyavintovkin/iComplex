<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    protected $table = 'post_hashtag';
    
    protected $fillable = ['post_id', 'hashtag_id'];

    public $timestamps = false; // если таблица не содержит created_at и updated_at
}