<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $record;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->record = Record::factory()->create();
    }

    public function testStore()
    {
        // PUTリクエスト(未認証)
        $response = $this->put('/records/' . $this->record->id . '/like');
        $response->assertRedirect(route('login'));

        // PUTリクエスト(認証済み)
        $response = $this->actingAs($this->user)->put('/records/' . $this->record->id . '/like');
        $response->assertStatus(200);

        // 配列にて指定の値の存在確認
        $data = $response->json();
        $this->assertEquals($this->record->id, $data['id']);
        $this->assertEquals($this->record->countLikes(), $data['countLikes']);

        // いいねがレコードに正しく追加されたかを確認
        $this->assertTrue($this->record->likes()->where('user_id', $this->user->id)->exists());
    }

    public function testDestroy()
    {
        // DELETEリクエスト(未認証)
        $response = $this->delete('/records/' . $this->record->id . '/unlike');
        $response->assertRedirect(route('login'));

        // DELETEリクエスト(認証済み)
        $response = $this->actingAs($this->user)->delete('/records/' . $this->record->id . '/unlike');
        $response->assertStatus(200);

        // DBからコメントが削除されているか確認
        $this->assertDatabaseEmpty('likes');

        // いいねがレコードから正しく削除されたかを確認
        $this->assertFalse($this->record->likes()->where('user_id', $this->user->id)->exists());
    }
}
