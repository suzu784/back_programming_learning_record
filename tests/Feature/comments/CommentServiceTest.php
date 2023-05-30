<?php

namespace Tests\Feature;

use App\Http\Requests\CommentRequest;
use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    private $comment_service;
    private $user;
    private $record;

    public function setUp(): void
    {
        parent::setUp();

        $this->comment_service = $this->app->make(CommentService::class);
        $this->user = User::factory()->create();
        $this->record = Record::factory()->create();
    }

    public function testStore()
    {
        // DBに値が保存されているか確認
        $this->actingAs($this->user);
        $comment_request = new CommentRequest();
        $comment_request->merge([
            'content' => 'こんにちは',
        ]);
        $this->comment_service->store($comment_request, $this->record->id);
        $this->assertDatabaseHas('comments', [
            'content' => 'こんにちは',
        ]);
    }
}
