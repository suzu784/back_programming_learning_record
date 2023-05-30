<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TemplateService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateServiceTest extends TestCase
{
    use RefreshDatabase;

    private $template_service;
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->template_service = $this->app->make(TemplateService::class);
        $this->user = User::factory()->create();
    }

    public function testStore()
    {
        // DBに値が保存されているか確認
        $this->actingAs($this->user);
        $request = new Request([
            'name' => 'テストテンプレート',
            'content' => "echo 'Hello World!';",
        ]);
        $this->template_service->store($request);
        $this->assertDatabaseHas('templates', [
            'name' => 'テストテンプレート',
        ]);
    }
}
