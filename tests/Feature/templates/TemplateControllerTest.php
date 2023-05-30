<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    private $user;
    private $template;

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->template = Template::factory()->create();
    }

    public function testIndex()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/api/templates');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/api/templates');
        $response->assertStatus(200);


        // 配列にて指定の値の存在確認
        $response = $this->actingAs($this->user)->get('/api/templates');
        $data = $response->json();
        $this->assertContains($this->template->name, $data);
    }

    public function testCreate()
    {
        // GETリクエスト(未認証)
        $response = $this->get('/templates/create');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('/templates/create');
        $response->assertStatus(200);
    }

    public function testStore()
    {
        // POSTリクエスト(未認証)
        $response = $this->post('/templates');
        $response->assertRedirect(route('login'));

        // POSTリクエスト(未認証)
        $response = $this->actingAs($this->user)->post('/templates', [
            'name' => $this->template->name,
            'content' => $this->template->content,
        ]);
        $response->assertRedirect(route('top'));

        // フラッシュメッセージの存在確認
        $response->assertSessionHas('msg_success', 'テンプレートを登録しました');
    }
}
