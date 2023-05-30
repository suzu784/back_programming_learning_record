<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testMyDrafts()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/records/users/' . $this->user->id . '/drafts');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/records/users/' . $this->user->id . '/drafts');
        $response->assertStatus(200);
        $response->assertViewIs('users.my_drafts');
    }

    public function testShowRecords()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/users/' . $this->user->id);
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/users/' . $this->user->id);
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('users.show');
    }

    public function testShowLikes()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/users/' . $this->user->id . '/likes');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/users/' . $this->user->id . '/likes');
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('users.likes');
    }

    public function testShowStudyAnalytics()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/users/' . $this->user->id . '/studyAnalytics');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/users/' . $this->user->id . '/studyAnalytics');
        $response->assertStatus(200);

        // 指定のViewの読み込み確認
        $response->assertViewIs('users.study_analytics');
    }

    public function testUpdateGoal()
    {
        // PUTリクエスト(未認証)
        $response = $this->put('/users/' . $this->user->id);
        $response->assertRedirect(route('login'));

        // PUTリクエスト()
        $response = $this->actingAs($this->user)->put('/users/' . $this->user->id, ['goal' => '今日も頑張りましょう']);
        $response->assertStatus(200);

        // DBに値を入れてその値が入っているかの確認
        $this->assertDatabaseHas('users', ['goal' => '今日も頑張りましょう']);
    }
}
