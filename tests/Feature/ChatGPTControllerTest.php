<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatGPTControllerTest extends TestCase
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

    public function testGetReview()
    {
        // GETリクエスト(未認証)
        $response = $this->get('records/' . $this->record->id . '/review');
        $response->assertRedirect(route('login'));

        // GETリクエスト(認証済み)
        $response = $this->actingAs($this->user)->get('records/' . $this->record->id . '/review');
        $response->assertRedirect(route('records.show', ['record' => $this->record->id]));
    }
}
