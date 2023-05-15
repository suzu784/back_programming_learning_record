<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentService
{
  /**
   * コメントを生成
   *
   * @param Request $request リクエスト
   * @param Record $record_id 学習記録ID
   * @return void
   */
  public function store(Request $request, $record_id)
  {
    Comment::create([
      'user_id' => $request->user()->id,
      'record_id' => $record_id,
      'content' => $request->input('content')
    ]);
  }
}