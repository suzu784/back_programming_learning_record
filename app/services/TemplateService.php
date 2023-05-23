<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateService
{
  /**
   * テンプレートを作成
   *
   * @param Request $request リクエスト
   * @return void
   */
  public function store(Request $request)
  {
    Template::create([
      'user_id' => Auth::id(),
      'name' => $request->input('name'),
      'content' => $request->input('content'),
    ]);
  }
}
