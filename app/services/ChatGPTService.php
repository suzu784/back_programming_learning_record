<?php

namespace App\Services;

use App\Models\Record;
use GuzzleHttp\Client;
use App\Models\ChatGPT;
use App\Services\ChatGPTServiceInterface;

class ChatGPTService implements ChatGPTServiceInterface
{
  /**
   * ChatGPTによるレビューを生成
   *
   * @param Record $record 学習記録
   * @return $generated_text レビュー
   */
  public function handle(Record $record)
  {
    $client = new Client([
      'base_uri' => 'https://api.openai.com/v1/'
    ]);

    $response = $client->post('completions', [
      'headers' => [
        'Authorization' => 'Bearer ' . config('chatgpt.api_key'),
        'Content-type' => 'application/json'
      ],
      'json' => [
        'model' => 'text-davinci-003',
        'prompt' => $record->body,
      ],
    ]);

    $result = json_decode($response->getBody()->getContents(), true);
    $generated_text = $result['choices'][0]['text'];
    return $generated_text;
  }

  /**
   * ChatGPTテーブルにデータを保存・更新
   *
   * @param Record $record 学習記録
   * @param $generated_text レビュー
   * @return void
   */
  public function saveGeneratedText(Record $record, $generated_text)
  {
    $chat_gpt_record = ChatGPT::where('record_id', $record->id)->first();
    if ($chat_gpt_record) {
      $chat_gpt_record->content = $generated_text;
      $chat_gpt_record->save();
    } else {
      ChatGPT::create([
        'record_id' => $record->id,
        'content' => $generated_text,
      ]);
    }
  }
}