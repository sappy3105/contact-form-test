<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:8'],
            'last_name' => ['required', 'string', 'max:8'],
            'gender' => ['required'],
            'email' => ['required', 'email'],
            'tel1' => ['required', 'numeric', 'digits_between:1,5'],
            'tel2' => ['required', 'numeric', 'digits_between:1,5'],
            'tel3' => ['required', 'numeric', 'digits_between:1,5'],
            'address' => ['required'],
            'category_id' => ['required'],
            'detail' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => '名を入力してください',
            'first_name.string' => '名を文字列で入力してください',
            'first_name.max' => '名を8文字以内で入力してください',
            'last_name.required'  => '姓を入力してください',
            'last_name.string' => '姓を文字列で入力してください',
            'last_name.max' => '姓を8文字以内で入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel1.numeric' => '電話番号は半角英数字で入力してください',
            'tel1.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel2.numeric' => '電話番号は半角英数字で入力してください',
            'tel2.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel3.numeric' => '電話番号は半角英数字で入力してください',
            'tel3.digits_between' => '電話番号は5桁まで数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }

    //電話番号のバリデーション処理。重複削除。メッセージの優先順位定義。
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = $validator->errors();

            $telErrors = array_merge(
                $errors->get('tel1'),
                $errors->get('tel2'),
                $errors->get('tel3')
            );

            if (!empty($telErrors)) {
                // 重複を削除
                $uniqueErrors = array_unique($telErrors);

                // 優先順位を定義
                $priority = [
                    '電話番号を入力してください',
                    '電話番号は半角英数字で入力してください',
                    '電話番号は5桁まで数字で入力してください',
                ];

                $sortedErrors = array_intersect($priority, $uniqueErrors);
                $extraErrors = array_diff($uniqueErrors, $priority);
                $finalErrors = array_merge($sortedErrors, $extraErrors);

                if (!empty($finalErrors)) {
                    $errors->add('tel_all', $finalErrors[0]);
                }
            }
        });
    }
}
