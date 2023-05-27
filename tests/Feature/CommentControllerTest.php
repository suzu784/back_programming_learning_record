<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $record;
    private $comment;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->record = Record::factory()->create(['user_id' => $this->user->id]);
        $this->comment = Comment::factory()->create(['user_id' => $this->user->id, 'record_id' => $this->record->id]);
    }

    public function testGetComments()
    {
        // GETリクエスト
        $response = $this->get('/comments/' . $this->record->id);
        $response->assertStatus(200);

        // 配列にて指定の値の存在確認
        $response = $this->get('/comments/' . $this->record->id);
        $data = $response->json();
        $this->assertEquals($this->comment->content, $data['comments'][0]['pivot']['content']);
    }

    public function testStore()
    {
        // POSTリクエスト(未認証)
        $response = $this->post('/records/comments');
        $response->assertRedirect(route('login'));

        // POSTリクエスト(認証済み)
        $response = $this->actingAs($this->user)->post('/records/comments', [
            'recordId' => $this->record->id,
            'content' => 'テストコメント',
        ]);
        $response->assertRedirect(route('records.show', ['record' => $this->record->id]));

        // DBに値が保存されているか確認
        $this->assertDatabaseHas('comments', ['content' => 'テストコメント']);
    }

    public function testUpdate()
    {
        // PUTリクエスト(未認証)
        $response = $this->put('/records/comments/' . $this->comment->id);
        $response->assertRedirect(route('login'));

        // PUTリクエスト(認証済み)
        $response = $this->actingAs($this->user)->put('/records/comments/' . $this->comment->id, [
            'content' => 'コメントを更新しました',
        ]);
        $response->assertStatus(200);

        // DBに値を入れてその値が入っているかの確認
        $this->assertDatabaseHas('comments', ['content' => 'コメントを更新しました']);
    }

    public function testDestroy()
    {
        // DELETEリクエスト(未認証)
        $response = $this->delete('/records/comments' . $this->comment->id);
        $response->assertRedirect(route('login'));

        // DELETEリクエスト(認証済み)
        $response = $this->actingAs($this->user)->delete('/records/comments/' . $this->comment->id);
        $response->assertStatus(200);

        // DBからコメントが削除されているか確認
        $this->assertDatabaseEmpty('comments');
    }
}
