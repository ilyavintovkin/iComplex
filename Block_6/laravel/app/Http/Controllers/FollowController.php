<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use App\Services\FollowService;
use Illuminate\Http\Request;

// Контроллер подписок
class FollowController extends Controller
{
    protected $followService; // сервис подписок

    public function __construct(FollowService $followService) 
    {
        $this->followService = $followService;
    }

    // Оформить подписку
    public function follow(Request $request)
    {
        $currentUserId = $request->input('currentUserId');  // Получение user_id текущего пользователя (кто нажал на кнопку подписаться)
        $userIdToFollow = $request->input('userIdToFollow');  // Получение user_id пользователя на которого оформляется подписка
    
        $message = $this->followService->follow($currentUserId, $userIdToFollow); // подписка
    
        return response()->json(['message' => $message]); //
    }

    // Оформить отписку
    public function unfollow(Request $request)
    {
        $currentUserId = $request->input('currentUserId');  // Получение user_id текущего пользователя (кто нажал на кнопку подписаться)
        $userIdToFollow = $request->input('userIdToUnfollow');  // Получение user_id пользователя на которого оформляется подписка

        $message = $this->followService->unfollow($currentUserId, $userIdToFollow); // отписка

        return response()->json(['message' => $message]); 
    }
}
