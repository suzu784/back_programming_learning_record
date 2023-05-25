<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testContentRequired()
    {
        $response = $this->post('/records/comments', [
            'content' => ''
        ]);

        $response->assertSessionHasErrors('content');
    }
}
