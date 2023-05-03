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
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * プロフィール画面のいいねした記事を表示
     *
     * @return view プロフィール画面
     */
    public function likes(User $user)
    {
        return view('users.likes', compact('user'));
    }
}
