<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         => 'required',
            'author'        => 'required',
            'genre'         => 'required',
            'description'   => 'required',
            'isbn'          => 'required|unique:books',
            'image'         => 'required',
            'published_at'  => 'required',
            'publisher'     => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'         => 'Book title is required',
            'author.required'        => 'Please mention Author',
            'genre.required'         => 'Please mention genre',
            'description.required'   => 'Description is required',
            'isbn.required'          => 'ISBN is mandatory',
            'isbn.unique'            => 'ISBN should be unique',
            'image.required'         => 'Please upload book cover',
            'published_at.required'  => 'Please mention date of publishing',
            'publisher.required'     => 'Please mention publisher',
        ];
    }

    /*** Get the error messages for the defined validation rules.** @return array*/
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(),'success' => false], 422));
    }
}
