<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AndroidAppRequest extends FormRequest
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
            'apk' => 'required|file',
            'version' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'apk.required' => 'apk file is required',
            'apk.file' => 'apk should be a file',
            'version.required' => 'name is required',
            'version.numeric' => 'version is not a numebr'
        ];
    }
}

