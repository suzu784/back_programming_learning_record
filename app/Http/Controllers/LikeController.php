<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * いいねする
     *
     * @param Request $request リクエスト
     * @param Record $record 学習記録
     * @return redirect 学習記録詳細ページ
     */
    public function store(Request $request, Record $record)
    {
        $record->likes()->detach($request->user()->id);
        $record->likes()->attach($request->user()->id);
        return  [
            'id' => $record->id,
            'countLikes' => $record->countLikes(),
        ];
    }

    /**
     * いいねを外す
     *
     * @param Request $request リクエスト
     * @param Record $record 学習記録
     * @return redirect 学習記録詳細ページ
     */
    public function destroy(Request $request, Record $record)
    {
        $record->likes()->detach($request->user()->id);
        return  [
            'id' => $record->id,
            'countLikes' => $record->countLikes(),
        ];
    }
}
