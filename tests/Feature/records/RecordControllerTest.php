<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $record;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->record = Record::factory()->create();
    }

    public function testIndex()
    {
        // GETリクエスト
        $response = $this->get('/');
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('records.index');
    }

    public function testShow()
    {
        // GETリクエスト
        $response = $this->get('/records/' . $this->record->id);
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('records.show');

        // 存在しない学習記録にアクセスしたときにエラー画面が表示
        $response = $this->get('/records/10');
        $response->assertStatus(404);
    }

    public function testEdit()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/records/' . $this->record->id . '/edit');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/records/' . $this->record->id . '/edit');
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('records.edit');
    }

    public function testStore()
    {
        // POSTリクエスト(未認証)
        $response = $this->post('/records');
        $response->assertRedirect(route('login'));

        // POSTリクエスト(認証済み)
        $response = $this->actingAs($this->user)->from('top')->post('/records', [
            'title' => $this->record->title,
            'body' => $this->record->body,
            'learning_date' => Carbon::now()->format('Y-m-d'),
            'duration' => '01:00',
        ]);
        $response->assertRedirect(route('top'));

        // フラッシュメッセージの存在確認
        $response->assertSessionHas('msg_success', '学習を記録しました');
    }

    public function testCreate()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/records/create');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/records/create');
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('records.create');
    }

    public function testUpdate()
    {
        // PUTリクエスト(未認証)
        $response = $this->put('/records/' . $this->record->id);
        $response->assertRedirect(route('login'));

        // PUTリクエスト(認証済み)
        $response = $this->actingAs($this->user)->put('/records/' . $this->record->id, [
            'title' => $this->record->title,
            'body' => $this->record->body,
            'learning_date' => Carbon::now()->format('Y-m-d'),
            'duration' => '01:00',
        ]);
        $response->assertRedirect(route('top'));

        // 投稿した内容の更新
        $response = $this->actingAs($this->user)->put('/records/' . $this->record->id, [
            'title' => 'タイトルを変更しました',
            'body' => $this->record->body,
            'learning_date' => Carbon::now()->format('Y-m-d'),
            'duration' => '01:00',
        ]);

        // DBに値を入れてその値が入っているかの確認
        $this->assertDatabaseHas('records', [
            'title' => 'タイトルを変更しました'
        ]);

        // フラッシュメッセージの存在確認
        $response->assertSessionHas('msg_success', '学習を記録しました');
    }

    public function testDestroy()
    {
        // DELETEリクエスト(未認証)
        $response = $this->delete('/records/' . $this->record->id);
        $response->assertRedirect(route('login'));

        // DELETEリクエスト(認証済み)
        $response = $this->actingAs($this->user)->delete('/records/' . $this->record->id, [
            'title' => $this->record->title,
            'body' => $this->record->body,
            'learning_date' => Carbon::now()->format('Y-m-d'),
            'duration' => '01:00',
        ]);
        $response->assertRedirect(route('top'));

        // フラッシュメッセージの存在確認
        $response->assertSessionHas('msg_success', '学習記録を削除しました');
    }
}
