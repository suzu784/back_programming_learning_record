<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Comment;
use App\Services\CommentService;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public $comment_service;

    /**
     * コメントのコンストラクタ
     *
     * @param CommentService $commentService コメントのサービスクラス
     */
    public function __construct(CommentService $commentService)
    {
        $this->comment_service = $commentService;
    }

    /**
     * 学習記録に対するコメントを取得
     *
     * @param Record $record 学習記録
     * @return $comments コメント
     */
    public function getComments(Record $record)
    {
        $comments = $record->comments;
        return [
            'comments' => $comments
        ];
    }

    /**
     * コメント後に学習記録詳細ページにリダイレクト
     *
     * @param CommentRequest $commentRequest リクエスト
     * @return redirect 学習記録の詳細ページ
     */
    public function store(CommentRequest $commentRequest)
    {
        $record_id = $commentRequest->input('recordId');
        $this->comment_service->store($commentRequest, $record_id);
        return redirect()->route('records.show', ['record' => $record_id]);
    }

    /**
     * コメント更新後に学習記録詳細ページに遷移
     *
     * @param CommentRequest $commentRequest リクエスト
     * @param Comment $comment コメント
     * @return void
     */
    public function update(CommentRequest $commentRequest, Comment $comment)
    {
        $comment->fill($commentRequest->all())->save();
    }

    /**
     * コメント削除後に学習記録詳細ページに遷移
     *
     * @param Comment $comment コメント
     * @return void
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
