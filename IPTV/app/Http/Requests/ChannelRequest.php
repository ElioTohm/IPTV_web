<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChannelRequest extends FormRequest
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
            'name' => 'required|max:25',
            'stream' => 'required',
            'thumbnail' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'stream.required'  => 'stream is required',
            'stream.url' => 'stream url is incorrect',
            'thumbnail.url' => 'thumbnail url is not correct'
        ];
    }
}
