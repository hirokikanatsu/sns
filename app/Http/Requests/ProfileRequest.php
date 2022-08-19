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
            'image' => ['image','mimes:jpeg,jpg,png','max:1024']
        ];
    }

    public function messages()
    {
        return [
            'image.image' => 'アイコン画像は写真にしてください',
            'image.mimes' => '拡張子が不正です',
            'image.max'  => 'ファイルサイズが大きすぎます'
        ];
    }
}
