<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
            'title'         => 'required|max:200',
            'author'        => 'required|max:200',
            'genre'         => 'required|max:200',
            'description'   => 'required|max:500',
            'isbn'          => 'required|numeric' ,
            'image'         => 'required|max:200',
            'published_at'  => 'required|date_format:Y-m-d',
            'publisher'     => 'required|max:200',
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
            'title.required'            => 'Book title is required',
            'author.required'           => 'Please mention Author',
            'genre.required'            => 'Please mention genre',
            'description.required'      => 'Description is required',
            'isbn.required'             => 'ISBN is mandatory',
            'isbn.unique'               => 'ISBN should be unique',
            'image.required'            => 'Please upload book cover',
            'published_at.required'     => 'Please mention date of publishing',
            'published_at.date_format'  => 'Please mention date in YYYY-MM-DD format',
            'publisher.required'        => 'Please mention publisher',
        ];
    }

    /*** Get the error messages for the defined validation rules.** @return array*/
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(),'success' => false], 422));
    }
}
