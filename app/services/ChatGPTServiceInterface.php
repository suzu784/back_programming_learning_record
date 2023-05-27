<?php

namespace App\Services;

use App\Models\Record;

interface ChatGPTServiceInterface
{
  public function handle(Record $record);

  public function saveGeneratedText(Record $record, $generated_text);
}