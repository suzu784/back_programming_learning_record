<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Record;
use GuzzleHttp\Client;
use App\Models\ChatGPT;
use App\Services\ChatGPTService;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\Services\ChatGPTServiceMock;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatGPTServiceTest extends TestCase
{
    use RefreshDatabase;

    private $chat_gpt_service;
    private $record;

    public function setUp(): void
    {
        parent::setUp();

        $this->chat_gpt_service = $this->app->make(ChatGPTService::class);
        $this->record = Record::factory()->create([
            'body' => 'テストプロンプト',
        ]);
    }

    public function testHandle()
    {
        // モックを作成
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'choices' => [
                    ['text' => 'モックを使ったテストです'],
                ],
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $chatGPTService = new ChatGPTServiceMock();

        $generatedText = $chatGPTService->handle($this->record);

        // 期待される結果と比較
        $this->assertEquals('モックを使ったテストです', $generatedText);
    }

    public function testSaveGeneratedText()
    {
        $record = $this->record;

        // テストケース1: 学習記録に対してChatGPTのレビューがない場合
        $generated_text = 'この文章はChatGPTによって生成された文章です';
        $this->chat_gpt_service->saveGeneratedText($record, $generated_text);

        $this->assertDatabaseHas('chat_g_p_t_s', [
            'content' => 'この文章はChatGPTによって生成された文章です',
        ]);

        // テストケース2: 学習記録に対してChatGPTのレビューがある場合
        $generated_text = 'この文章はChatGPTによって更新された文章です';
        $this->chat_gpt_service->saveGeneratedText($record, $generated_text);

        $this->assertTrue(ChatGpt::pluck('content')->contains('この文章はChatGPTによって更新された文章です'));

        // テストケース3: ChatGPTのレビューの更新確認
        $this->assertFalse(ChatGpt::pluck('content')->contains('この文章はChatGPTによって生成された文章です'));
    }
}
