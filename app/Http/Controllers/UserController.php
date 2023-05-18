<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * ユーザーの下書き一覧を表示
     *
     * @return view 下書き一覧
     */
    public function myDrafts(User $user)
    {
        $my_drafts = $user->myDrafts()->paginate(8);
        return view('users.my_drafts', compact('user', 'my_drafts'));
    }

    /**
     * プロフィール画面の記事を表示
     *
     * @param User $user ユーザー
     * @return view プロフィール画面
     */
    public function showRecords(User $user)
    {
        $records = $user->records()->paginate(8);
        return view('users.show', compact('user', 'records'));
    }

    /**
     * プロフィール画面のいいねした記事を表示
     *
     * @param User $user ユーザー
     * @return view プロフィール画面
     */
    public function showLikes(User $user)
    {
        $likes = $user->likes()->paginate(8);
        return view('users.likes', compact('user', 'likes'));
    }

    /**
     * プロフィール画面の学習記録の統計を表示
     *
     * @param User $user ユーザー
     * @return view プロフィール画面
     */
    public function showStudyAnalytics(User $user)
    {
        return view('users.study_analytics', compact('user'));
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
