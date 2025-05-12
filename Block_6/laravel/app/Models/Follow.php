<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [ // Указание, какие поля можно массово заполнять
        'follower_id',
        'followed_id',
    ];

    // Отношение: кто подписался
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id'); // Означает, что Follow принадлежит пользователю, который подписался
    }

    // Отношение: на кого подписались
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id'); // Означает, что Follow принадлежит пользователю на которого подписались
    }
}