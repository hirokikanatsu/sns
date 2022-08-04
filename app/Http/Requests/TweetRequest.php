<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TweetRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'tweet' => ['required', 'max:300'],
        ];
    }


    public function messages()
    {
        return [
            'tweet.required' => 'ツイート本文は必ず入力してください。',
            'tweet.max' => 'ツイートは300文字以内にしてください'
        ];
    }
}
