<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoiresRequest extends FormRequest
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
        $roles =  [
            'categories_name' => 'required',

        ];


        return $roles;
    }
    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
        ];
    }
}
