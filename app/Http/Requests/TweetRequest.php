<?php

namespace App\Http\Requests;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request)
    {
        $file = $request->file_name;
        $file_ext = pathinfo($file, PATHINFO_EXTENSION);
        // $file_ext = File::extension($file);
        if($file_ext == 'mp4' || $file_ext == 'mov'){
            return [
                'tweet' => ['required', 'max:300'],
                'image' => ['mimes:mov,mp4','max:56000'],
            ];
        }else{
            return [
                'tweet' => ['required', 'max:300'],
                'image' => ['mimes:jpeg,jpg,png','max:1024'],
            ];
        }
    }


    public function messages()
    {
        return [
            'tweet.required' => 'ツイート本文は必ず入力してください。',
            'tweet.max' => 'ツイートは300文字以内にしてください',
            'image.mimes' => '拡張子が不正です',
            'image.max'  => 'ファイルサイズが大きすぎます'
        ];
    }
}
