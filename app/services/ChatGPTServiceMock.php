<?php

namespace App\Services;

use App\Models\Record;
use App\Models\ChatGPT;
use App\Services\ChatGPTServiceInterface;

class ChatGPTServiceMock implements ChatGPTServiceInterface
{
  public function handle(Record $record)
  {
      $generated_text = 'モックを使ったテストです';
      return $generated_text;
  }

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