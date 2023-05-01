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
    $records = Record::orderBy('created_at', 'desc')->get();
    return $records;
  }

  /**
   * 学習記録詳細を取得
   *
   * @param Record $record
   * @return $record 学習記録
   */
  public function show($record)
  {
    $record = Record::where('id', $record)->first();
    return $record;
  }

  /**
   * 学習記録を作成
   *
   * @param Request $request リクエスト
   * @return void
   */
  public function store($request, $total_minute)
  {
    Record::create([
      'user_id' => Auth::id(),
      'title' => $request->input('title'),
      'body' => $request->input('body'),
      'learning_date' => $request->input('learning_date'),
      'duration' => $total_minute,
    ]);
  }
}
