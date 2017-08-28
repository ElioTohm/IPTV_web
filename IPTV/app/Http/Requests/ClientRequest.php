<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
             'name'  => 'required',
             'email' => 'required',
             'room' => 'required',
             'credit' => 'required',
             'debit' => 'required',
         ];
     }
 
     public function messages()
     {
         return [
             'name.required' => 'Name is required',
             'email.required' => 'Name is required',
             'room.required' => 'Name is required',
             'credit.required' => 'Name is required',
             'debit.required' => 'Name is required',
         ];
     }
}
