<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'name' => 'required|min:2|max:255',
            'description' => 'string|max:1000',
            'images' => 'required',
            'images.*' => 'required|url|ends_with:pdf,jpg,jpeg'
        ];
    }
    public function messages()
    {
        return [
            'images.*.ends_with' => 'Image must be of a pdf, jpg or jpeg format',
            'images.*.url' => 'Image must be a valid url',
        ];
    }
}
