<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentService
{
  /**
   * コメントを生成
   *
   * @param CommentRequest $commentRequest リクエスト
   * @param Record $record_id 学習記録ID
   * @return void
   */
  public function store(CommentRequest $comment_request, $record_id)
  {
    Comment::create([
      'user_id' => Auth::id(),
      'record_id' => $record_id,
      'content' => $comment_request->input('content')
    ]);
  }
}