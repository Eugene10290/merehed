<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class BooksUpdateRequest extends FormRequest
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
            'name'         => 'string|min:3|max:255',
            'author_id'    => 'integer',
            'pages_number' => 'integer',
            'annotation'   => 'string|min:10|max:3555',
            'image_path'   => 'string',
        ];
    }
}
