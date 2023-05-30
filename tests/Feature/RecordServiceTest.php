<?php

namespace Tests\Feature;

use App\Http\Requests\RecordRequest;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use App\Models\ChatGPT;
use Illuminate\Http\Request;
use App\Services\RecordService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordServiceTest extends TestCase
{
    use RefreshDatabase;

    private $record_service;
    private $user;
    private $record;
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->record_service = $this->app->make(RecordService::class);
        $this->user = User::factory()->create();
        $this->record = Record::factory()->create();
        $this->request = new Request([
            'tagName' => 'Laravel,Docker'
        ]);
    }

    public function testGetWeekDate()
    {
        // 1週間の日付(Y-m-d)の取得確認
        $week_date = $this->record_service->getWeekDate();
        $start_date = Carbon::today()->subDay(6);
        $end_date = $start_date->copy()->addDay(6);
        $this->assertEquals($week_date[0], $start_date->toDateString());
        $this->assertEquals($week_date[6], $end_date->toDateString());
    }

    public function testGetTotalStudyTime()
    {
        $this->actingAs($this->user);

        // テスト用の学習記録を作成
        $record1 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->subDays(6)->toDateString(),
            'duration' => 120,
        ]);
        $record2 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->subDays(5)->toDateString(),
            'duration' => 90,
        ]);
        // この日の学習記録は存在しない
        // $record3 = Record::factory()->create([
        //     'user_id' => $this->user->id,
        //     'learning_date' => Carbon::today()->subDays(4)->toDateString(),
        //     'duration' => 60,
        // ]);
        $record4 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->subDays(3)->toDateString(),
            'duration' => 150,
        ]);
        $record5 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->subDays(2)->toDateString(),
            'duration' => 120,
        ]);
        $record6 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->subDays(1)->toDateString(),
            'duration' => 180,
        ]);
        $record7 = Record::factory()->create([
            'user_id' => $this->user->id,
            'learning_date' => Carbon::today()->toDateString(),
            'duration' => 60,
        ]);

        $total_study_time = $this->record_service->getTotalStudyTime();

        $expected_study_time = [120, 90, 0, 150, 120, 180, 60];

        // 学習時間が期待される値であることを確認
        $this->assertEquals($expected_study_time, $total_study_time);
    }

    public function testConvertTotalMinutesToHours()
    {
        // テストケース1: 120分の場合
        $duration = 120;
        $expected_hours = 2;
        $result = $this->record_service->convertTotalMinutesToHours($duration);
        $this->assertEquals($expected_hours, $result);

        // テストケース2: 90分の場合
        $duration = 90;
        $expected_hours = 1;
        $result = $this->record_service->convertTotalMinutesToHours($duration);
        $this->assertEquals($expected_hours, $result);
    }

    public function testConvertTotalMinutesToMinutes()
    {
        // テストケース1: 60分の場合
        $duration = 60;
        $expected_minutes = 0;
        $result = $this->record_service->convertTotalMinutesToMinutes($duration);
        $this->assertEquals($expected_minutes, $result);

        // テストケース2: 65分の場合
        $duration = 65;
        $expected_minutes = 5;
        $result = $this->record_service->convertTotalMinutesToMinutes($duration);
        $this->assertEquals($expected_minutes, $result);
    }

    public function testConvertHHMMToTotalMinute()
    {
        // 学習時間(HHMM)を時間(分単位)に変換できているか確認
        $duration = '01:00';
        $expected_total_minute = 60;
        $result = $this->record_service->convertHHMMToTotalMinute($duration);
        $this->assertEquals($expected_total_minute, $result);
    }

    public function testGetGeneratedText()
    {
        // テストケース1: レビューがない場合
        $chat_gpt_record = null;
        $result = $this->record_service->getGeneratedText($this->record);
        $this->assertEquals(null, $result);

        // テストケース2: レビューがある場合
        $chat_gpt_record = ChatGPT::create([
            'record_id' => $this->record->id,
            'content' => '今日も1日頑張りましょう',
        ]);
        $result = $this->record_service->getGeneratedText($this->record);
        $this->assertEquals($chat_gpt_record->content, $result);
    }

    public function testGetFlashMessage()
    {
        // フラッシュメッセージの存在確認
        $this->record_service->flash_message = 'フラッシュメッセージです';
        $expected_flash_message = 'フラッシュメッセージです';
        $result = $this->record_service->getFlashMessage();
        $this->assertEquals($expected_flash_message, $result);
    }

    public function testStringToArray()
    {
        // 文字列が配列になっているか確認
        $tag_name = 'Laravel,Docker';
        $expected_tag_array = ['Laravel', 'Docker'];
        $result = $this->record_service->stringToArray($tag_name);
        $this->assertEquals($expected_tag_array, $result);
    }

    public function testProcessTags()
    {
        $request = $this->request;
        $record = $this->record;
        $this->record_service->processTags($request, $record);

        // DBに値が保存されているか確認
        $this->assertCount(2, $record->tags);
        $this->assertTrue($record->tags->pluck('name')->contains('Laravel'));
        $this->assertTrue($record->tags->pluck('name')->contains('Docker'));
    }

    public function testCreateTags()
    {
        $request = $this->request;
        $record = $this->record;
        $this->record_service->createTags($request, $record);

        // DBに値が保存されているか確認
        $this->assertCount(2, $record->tags);
        $this->assertTrue($record->tags->pluck('name')->contains('Laravel'));
        $this->assertTrue($record->tags->pluck('name')->contains('Docker'));
    }

    public function testUpdateTags()
    {
        $request = new Request(['tagName' => 'PHP,AWS']);
        $record = $this->record;
        $this->record_service->updateTags($request, $record);

        // DBの値が更新されているか確認
        $this->assertCount(2, $record->tags);
        $this->assertTrue($record->tags->pluck('name')->contains('PHP'));
        $this->assertTrue($record->tags->pluck('name')->contains('AWS'));
    }

    public function testDestroyTags()
    {
        $request = $this->request;
        $record = $this->record;
        $this->record_service->destroyTags($request, $record);

        // DBの値が削除されているか確認
        $this->assertCount(0, $record->tags);
    }

    public function testIndex()
    {
        // テストケース1: キーワードが含まれているとき
        $request = new Request([
            'keyword' => $this->record->title,
        ]);
        $result = $this->record_service->index($request);
        $this->assertTrue($result->contains('id', $this->record->id));

        // テストケース2: キーワードが含まれていないとき
        $records = Record::factory()->count(3)->create();
        $request = new Request();
        $result = $this->record_service->index($request);
        foreach ($records as $record) {
            $this->assertTrue($result->contains('id', $record->id));
        }
    }

    public function testStore()
    {
        // テストケース1: 下書き保存によるDBへの値の保存、フラッシュメッセージ
        $this->actingAs($this->user);
        $record = $this->record;
        $record_request = new RecordRequest([
            'title' => 'テストタイトル',
            'body' => 'PHPを学習しました',
            'is_draft' => true,
            'learning_date' => $record->learning_date,
        ]);
        $total_minute = 120;

        $this->record_service->store($record_request, $total_minute);

        // DBに値が保存されているか確認
        $this->assertDatabaseHas('records', [
            'body' => 'PHPを学習しました',
        ]);

        $this->assertDatabaseEmpty('tags');

        // フラッシュメッセージの存在確認
        $expected_flash_message = '下書きを保存しました';
        $this->assertEquals($expected_flash_message, $this->record_service->flash_message);

        // テストケース2: 学習記録を投稿によるDBへの値の保存、フラッシュメッセージ
        $record_request = new RecordRequest([
            'title' => 'テストタイトル',
            'body' => 'Rubyを学習しました',
            'learning_date' => $record->learning_date,
            'tagName' => 'rails',
        ]);
        $total_minute = 60;

        $this->record_service->store($record_request, $total_minute);

        // DBに値が保存されているか確認
        $this->assertDatabaseHas('records', [
            'body' => 'Rubyを学習しました',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'rails',
        ]);

        // フラッシュメッセージの存在確認
        $expected_flash_message = '学習を記録しました';
        $this->assertEquals($expected_flash_message, $this->record_service->flash_message);
    }

    public function testUpdate()
    {
        $record = $this->record;
        $record_request = new RecordRequest([
            'title' => 'テストタイトル',
            'body' => 'Pythonを学習しました',
            'is_draft' => true,
            'learning_date' => $record->learning_date,
            'duration' => '01:00',
            'tagName' => 'Python,Django',
        ]);

        $this->record_service->Update($record_request, $record);

        // DBに値が保存されているか確認
        $this->assertTrue($record->pluck('body')->contains('Pythonを学習しました'));

        // フラッシュメッセージの存在確認
        $expected_flash_message = '下書きを保存しました';
        $this->assertEquals($expected_flash_message, $this->record_service->flash_message);

        $record_request = new RecordRequest([
            'title' => 'テストタイトル',
            'body' => 'Dockerを学習しました',
            'learning_date' => $record->learning_date,
            'duration' => '02:00',
            'tagId' => $record->tags->pluck('id')->toArray(),
            'tagName' => $this->request['tagName'],
        ]);

        $this->record_service->Update($record_request, $record);

        // DBに値が保存されているか確認
        $this->assertTrue($record->pluck('body')->contains('Dockerを学習しました'));

        // フラッシュメッセージの存在確認
        $expected_flash_message = '学習を記録しました';
        $this->assertEquals($expected_flash_message, $this->record_service->flash_message);
    }
}
