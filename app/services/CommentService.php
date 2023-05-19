<?php

namespace App\Services;

use App\Models\Comment;
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
  public function store(CommentRequest $commentRequest, $record_id)
  {
    Comment::create([
      'user_id' => $commentRequest->user()->id,
      'record_id' => $record_id,
      'content' => $commentRequest->input('content')
    ]);
  }
}