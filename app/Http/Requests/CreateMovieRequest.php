<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMovieRequest extends FormRequest
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
        return
        [
            'title'         => ['required'],
            'release'       => ['required','date'],
            'length'        => ['required','integer'],
            'description'   => ['required'],
            'mpaa_rating'   => ['required'],
            'genre'         => ['required'],
            'director'      => ['required'],
            'performer'     => ['required'],
            'language'      => ['required']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => true,
            'message' => 'Validation errors',
            'details' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
