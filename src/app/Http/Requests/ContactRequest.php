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
            'first_name' => ['string', 'max:8'],
            'last_name' => ['string', 'max:8'],
            'gender' => ['required'],
            'email' => ['required', 'email'],
            'tel1' => ['required', 'max:5', 'regex:/^[0-9]+$/'],
            'tel2' => ['required', 'max:5', 'regex:/^[0-9]+$/'],
            'tel3' => ['required', 'max:5', 'regex:/^[0-9]+$/'],
            'address' => ['required'],
            'building' => ['nullable'],
            'category_id' => ['required'],
            'detail' => ['required', 'max:120'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $last = $this->input('last_name');
            $first = $this->input('first_name');

            if (empty($last) && empty($first)) {
                $validator->errors()->add('name', 'お名前を入力してください');
            }
            if (empty($last)) {
                $validator->errors()->add('last_name', '姓を入力してください');
            }
            if (empty($first)) {
                $validator->errors()->add('first_name', '名を入力してください');
            }
        });
    }
    public function messages()
    {
        return [
            'first_name.string' => '名を正しく入力してください',
            'first_name.max' => '名は８文字以内で入力してください',
            'last_name.string' => '姓を正しく入力してください',
            'last_name.max' => '姓は８文字以内で入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel1.max' => '電話番号は５桁までの数字で入力してください',
            'tel1.regex' => '電話番号は半角数字で入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel2.max' => '電話番号は５桁までの数字で入力してください',
            'tel2.regex' => '電話番号は半角数字で入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel3.max' => '電話番号は５桁までの数字で入力してください',
            'tel3.regex' => '電話番号は半角数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせの内容を入力してください',
            'detail.max' => 'お問い合わせの内容は１２０文字以内で入力してください'
        ];
    }
}
