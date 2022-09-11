<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required','max:10'],
            'email' => ['required','max:255'],
            'password' => ['required','confirmed'],
            'image' => ['image','mimes:jpeg,jpg,png','max:1024']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前は入力必須項目です',
            'name.max' => '名前は10文字以内で登録してください',
            'email.required' => 'メールアドレスは入力必須項目です',
            'email.max' => 'メールアドレスが不正です',
            'password.required' => 'パスワードは入力必須項目です',
            'password.confirmed' => 'パスワードと確認用パスワードが一致しません',
            'image.image' => 'アイコン画像は写真にしてください',
            'image.mimes' => '拡張子が不正です',
            'image.max'  => 'ファイルサイズが大きすぎます'
        ];
    }
}
