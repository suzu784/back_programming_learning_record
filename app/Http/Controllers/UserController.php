<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * プロフィール画面の記事を表示
     *
     * @return view プロフィール画面
     */
    public function showRecords(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * プロフィール画面のいいねした記事を表示
     *
     * @return view プロフィール画面
     */
    public function showLikes(User $user)
    {
        return view('users.likes', compact('user'));
    }

    /**
     * ユーザーの目標を更新
     *
     * @param Request $request リクエスト
     * @return void
     */
    public function updateGoal(Request $request)
    {
        $user = $request->user();
        $goal = $request->goal;
        $user->goal = $goal;
        $user->save();
    }
}