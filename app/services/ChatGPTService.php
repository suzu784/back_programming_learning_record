<?php

namespace App\Services;

use App\Models\Record;
use GuzzleHttp\Client;

class ChatGPTService
{
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
        'max_tokens' => 600,
      ],
    ]);

    $result = json_decode($response->getBody()->getContents(), true);
    $generated_text = $result['choices'][0]['text'];
    return $generated_text;
  }
}