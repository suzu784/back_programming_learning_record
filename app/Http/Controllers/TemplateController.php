<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * 投稿時のテンプレートを選択
     *
     * @return json($templates) テンプレート
     */
    public function index()
    {
        $templates = Template::pluck('name')->toArray();
        return response()->json($templates);
    }
}
