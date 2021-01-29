<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
        $rules = [
            'title' => 'required|max:255',
            'price' => 'required|numeric|min:1',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:7168',
        ];

        if($this->route()->named('create.ad')){
            $rules['image'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'price.required' => 'Поле Цена обязательно для заполнения.',
            'image.required' => 'У объявления должна быть хотя-бы одна фотография.',
        ];
    }
}
