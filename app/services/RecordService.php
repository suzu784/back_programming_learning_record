<?php

namespace App\Services;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordService
{
  /**
   * 合計時間を分から時間に変換する
   *
   * @param Record $duration 合計時間(HH:MM)
   * @return $hours 時間
   */
  public function convertTotalMinutesToHours($duration)
  {
    $hours = floor($duration / 60);
    return $hours;
  }

  /**
   * 合計時間を分から時間に変換する
   *
   * @param Record $duration 合計時間(HH:MM)
   * @return $minutes 分
   */
  public function convertTotalMinutesToMinutes($duration)
  {
    $minutes = $duration % 60;
    return $minutes;
  }

  /**
   * HH:MMから合計時間に変換する
   *
   * @param Record $duration 合計時間(HH:MM)
   * @return $total_minute 合計時間
   */
  public function convertHHMMToTotalMinute($duration)
  {
    $duration_arr = explode(':', $duration); // ":"で分割し、時間と分を配列で取得する
    $hours = $duration_arr[0]; // 時間を取得する
    $minutes = $duration_arr[1]; // 分を取得する
    $total_minute = ($hours * 60) + $minutes; // 時間を60で乗じて分に変換し、分と合算する
    return $total_minute;
  }

  /**
   * 学習記録一覧を取得
   *
   * @return $records 学習記録一覧
   */
  public function index()
  {
    $records = Record::NotDraft()->orderBy('created_at', 'desc')->get();
    return $records;
  }

  /**
   * 学習記録を作成
   *
   * @param Request $request リクエスト
   * @return void
   */
  public function store(Request $request, $total_minute)
  {
    Record::create([
      'user_id' => Auth::id(),
      'title' => $request->input('title'),
      'body' => $request->input('body'),
      'is_draft' => $request->has('is_draft'),
      'learning_date' => $request->input('learning_date'),
      'duration' => $total_minute,
    ]);
  }

  /**
   * 学習記録を更新
   *
   * @param Request $request
   * @param Record $record
   * @return void
   */
  public function update(Request $request, Record $record)
  {
    $duration = $request->input('duration');
    $total_minute = $this->convertHHMMToTotalMinute($duration);
    $record->fill(array_merge($request->except('is_draft'), ['duration' => $total_minute]))->save();
    if ($request->has('is_draft')) { // 下書き保存の場合
      return;
    }
    $record->is_draft = false; // 更新の場合
    $record->save();
  }
}
