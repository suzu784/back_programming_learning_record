<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public $template_service;

    /**
     * テンプレートのコンストラクタ
     *
     * @param TemplateService $template_service テンプレートのサービスクラス
     */
    public function __construct(TemplateService $template_service)
    {
        $this->template_service = $template_service;
    }
    
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

    /**
     * テンプレート登録画面に遷移
     *
     * @return view テンプレート登録画面
     */
    public function create()
    {
        return view('records.register_template');
    }

    /**
     * テンプレートを作成してトップページにリダイレクト
     *
     * @param Request $request リクエスト
     * @return redirect トップページ
     */
    public function store(Request $request)
    {
        $this->template_service->store($request);
        return redirect()->route('top');
    }
}
