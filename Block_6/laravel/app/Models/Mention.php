<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['post_id', 'mentioned_user_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function mentionedUser()
    {
        return $this->belongsTo(User::class, 'mentioned_user_id');
    }
}
