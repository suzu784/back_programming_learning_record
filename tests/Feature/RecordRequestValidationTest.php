<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testTitleRequired()
    {
        $response = $this->post('/records', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testTitleMaxLength()
    {
        $response = $this->post('/records', [
            'title' => '今日はプログラミング学習アプリの新機能を追加しました。ユーザーは学習記録を投稿できます。投稿にはタイトルと内容が必要で、タイトルは50文字以内、内容は100文字以内である必要があります。また、学習日と学習時間も入力できます。ユーザーは自分の投稿を編集や削除することもできます。これにより、ユーザーは自分の学習の進捗を記録し、振り返ることができます。学習のモチベーション向上にも貢献する機能です。',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testBodyRequired()
    {
        $response = $this->post('/records', [
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function testLearningDateRequired()
    {
        $response = $this->post('/records', [
            'learning_date' => '',
        ]);

        $response->assertSessionHasErrors('learning_date');
    }

    public function testLearningDateDateFormat()
    {
        $response = $this->post('/records', [
            'learning_date' => 01 - 01,
        ]);

        $response->assertSessionHasErrors('learning_date');
    }

    public function testLearningDateBeforeOrEqual()
    {
        $response = $this->post('/records', [
            'learning_date' => 9999 - 01 - 01,
        ]);

        $response->assertSessionHasErrors('learning_date');
    }

    public function testLearningDateAfter()
    {
        $response = $this->post('/records', [
            'learning_date' => 1999 - 01 - 01,
        ]);

        $response->assertSessionHasErrors('learning_date');
    }

    public function testDurationRequired()
    {
        $response = $this->post('/records', [
            'duration' => '',
        ]);

        $response->assertSessionHasErrors('duration');
    }

    public function testDurationDateFormat()
    {
        $response = $this->post('/records', [
            'duration' => 00 - 00 - 00,
        ]);

        $response->assertSessionHasErrors('duration');
    }

    public function testDurationAfter()
    {
        $response = $this->post('/records', [
            'duration' => 00 - 00,
        ]);

        $response->assertSessionHasErrors('duration');
    }
}
