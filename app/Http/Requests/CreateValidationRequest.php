<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Uppercase;

class CreateValidationRequest extends FormRequest
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
            'name' => ['required','unique:cars'],
            'founded' => ['required','integer','min:0','max:2023'],
            'description' => ['required'],
            'image' => ['required'],['mimes:png,jpg,jpeg'],['max:5048'],
        ];
    }
}
