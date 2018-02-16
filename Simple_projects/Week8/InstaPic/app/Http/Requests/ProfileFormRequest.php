<?php

namespace InstaPic\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
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
            'displayname'=> 'required|max:20',
            'avatar'=> 'mimes:jpeg,png,jpg',
            'bio'=> 'max:1000',
            'cover'=> 'mimes:jpeg,png,jpg',
            'website'=> 'max:200',
            'gender'=> 'required|max:50',
            'mobile'=> 'required|min:8|numeric',
        ];
    }
}
