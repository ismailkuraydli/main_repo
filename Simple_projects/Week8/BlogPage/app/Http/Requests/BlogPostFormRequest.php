<?php

namespace OpenBook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostFormRequest extends FormRequest
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
            'title'=>'required|max:100',
            'body'=> 'required|max:1000',
            'image'=> 'required|max:300',
            'tags'=> 'required|max:100',
        ];
    }
}
