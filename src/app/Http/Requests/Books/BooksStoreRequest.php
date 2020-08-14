<?php

namespace App\Http\Requests\Books;

use Illuminate\Foundation\Http\FormRequest;

class BooksStoreRequest extends FormRequest
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
            'name'         => 'required|string|min:3|max:255',
            'author_id'    => 'required|integer',
            'pages_number' => 'required|integer',
            'annotation'   => 'required|string|min:10|max:3555',
            'image_path'   => 'required|mimes:jpeg,png',
        ];
    }
}
