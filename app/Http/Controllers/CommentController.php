<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;

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
     * @param Request $request リクエスト
     * @return redirect 学習記録の詳細ページ
     */
    public function store(Request $request)
    {
        $record_id = $request->input('recordId');
        $this->comment_service->store($request, $record_id);
        return redirect()->route('records.show', ['record' => $record_id]);
    }

    /**
     * コメント更新後に学習記録詳細ページに遷移
     *
     * @param Request $request リクエスト
     * @param Comment $comment コメント
     * @return void
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->fill($request->all())->save();
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
