<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Services\RecordService;
use App\Http\Requests\RecordRequest;

class RecordController extends Controller
{
    public $record_service;

    /**
     * 学習記録のコンストラクタ
     *
     * @param RecordService $record_service 学習記録のサービスクラス
     */
    public function __construct(RecordService $record_service)
    {
        $this->record_service = $record_service;
    }

    /**
     * 1週間以内の1日あたりの合計学習時間
     *
     * @return void
     */
    public function getTotalStudyTime()
    {
        $learning_date = $this->record_service->getWeekDate();
        $total_study_time = $this->record_service->getTotalStudyTime();

        $return_array = [];
        for ($i = 0; $i < 7; $i++) {
            $return_array[$learning_date[$i]] = $total_study_time[$i];
        }
        return [
            $return_array
        ];
    }

    /**
     * 学習記録一覧画面に遷移
     *
     * @param Request $request リクエスト
     * @return view 学習記録一覧画面
     */
    public function index(Request $request)
    {
        $records = $this->record_service->index($request);
        return view('records.index', compact('records'));
    }

    /**
     * 学習記録の詳細画面に遷移
     *
     * @param Record $record 学習記録
     * @return view 学習詳細画面
     */
    public function show(Record $record)
    {
        $duration = $record->duration;
        $hours = $this->record_service->convertTotalMinutesToHours($duration);
        $minutes = $this->record_service->convertTotalMinutesToMinutes($duration);
        $generated_text = $this->record_service->getGeneratedText($record);
        return view('records.show', compact(
            'record',
            'hours',
            'minutes',
            'generated_text',
        ));
    }

    /**
     * 学習記録を作成してトップページにリダイレクト
     *
     * @param RecordRequest $recordRequest リクエスト
     * @return redirect トップページ
     */
    public function store(RecordRequest $recordRequest)
    {
        $duration = $recordRequest->input('duration');
        $total_minute = $this->record_service->convertHHMMToTotalMinute($duration);
        $this->record_service->store($recordRequest, $total_minute);
        $flash_message = $this->record_service->getFlashMessage();
        return redirect()->route('top')->with('msg_success', $flash_message);
    }

    /**
     * 学習記録フォーム画面に遷移
     *
     * @return view 学習記録フォーム画面
     */
    public function create()
    {
        return view('records.create');
    }

    /**
     * 学習記録編集フォーム画面に遷移
     *
     * @param Record $record 学習記録
     * @return view 学習記録編集画面
     */
    public function edit(Record $record)
    {
        $duration = $record->duration;
        $hours = $this->record_service->convertTotalMinutesToHours($duration);
        $minutes = $this->record_service->convertTotalMinutesToMinutes($duration);
        return view('records.edit', compact(
            'record',
            'hours',
            'minutes',
        ));
    }

    /**
     * 学習記録を更新してトップページにリダイレクト
     *
     * @param RecordRequest $recordRequest リクエスト
     * @param Record $record 学習記録
     * @return redirect トップページ
     */
    public function update(RecordRequest $recordRequest, Record $record)
    {
        $this->record_service->update($recordRequest, $record);
        $flash_message = $this->record_service->getFlashMessage();
        return redirect()->route('top')->with('msg_success', $flash_message);
    }

    /**
     * 学習記録を削除してトップページにリダイレクト
     *
     * @param Record $record 学習記録
     * @param RecordRequest $recordRequest リクエスト
     * @return redirect トップページ
     */
    public function destroy(RecordRequest $recordRequest, Record $record)
    {
        $this->record_service->destroyTags($recordRequest, $record);
        $record->delete();
        return redirect()->route('top');
    }
}
