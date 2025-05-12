<?php

namespace App\Services;

use App\Models\Follow;

class FollowService
{
    // Метод процедуры подписки
    public function follow(int $currentUserId, int $userIdToFollow): string
    {
        if ($currentUserId === $userIdToFollow) { // проверка на "подписка на самого себя"
            return 'Нельзя подписаться на самого себя';
        }

        $alreadyFollowing = Follow::where('follower_id', $currentUserId) // проверка на "уже подписан". Ищем в подписчиках текущего пользователя
            ->where('followed_id', $userIdToFollow) // где он подписан на пользователя, на которого пытаемся подписаться
            ->exists(); // проверка на существование такой записи

        if ($alreadyFollowing) { // если существует - значит currentUserId уже подписан на userIdToFollow
            return 'Уже подписан!';
        }
        
        Follow::create([ // создание записи follow 
            'follower_id' => $currentUserId, // в качестве подписчика выступает текущий пользователь
            'followed_id' => $userIdToFollow, // на кого подписываемся -  userIdToFollow
        ]);

        return 'Подписка оформлена!';
    }

    // Метод процедуры отписки
    public function unfollow(int $currentUserId, int $userIdToUnfollow): string
    {
        // Удаляем запись о подписке
        $deleted = Follow::where('follower_id', $currentUserId) // ищем запись в таблице, где подписчик - $currentUserId
            ->where('followed_id', $userIdToUnfollow) // а на кого подписан - $userIdToUnfollow)
            ->delete(); // удаляем эту запись

        return $deleted ? 'Успешно отписались' : 'Вы не подписаны на этого пользоателя';
    }
}
