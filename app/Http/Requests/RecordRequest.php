<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:150',
            'body' => 'required',
            'learning_date' => 'required|date_format:Y-m-d|before_or_equal:today|after:"-1 year',
            'duration' => 'required|date_format:H:i|after:00:00',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルを入力してください',
            'title.max' => 'タイトルは150文字以内で入力してください',
            'body.required' => '学習内容を入力してください',
            'learning_date.required' => '学習日は必要です',
            'learning_date.date_format' => 'Y-m-d形式で入力してください',
            'learning_date.before_or_equal' => '未来の日付は入力できません',
            'learning_date.after' => '1年以内で入力してください',
            'duration.required' => '学習時間は必要です',
            'duration.date_format' => 'H:i形式で入力してください',
            'duration.after' => '1分以上必要です',
        ];
    }
}
