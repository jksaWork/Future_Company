<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' =>'required',
            'email' => 'required|exists:employees,email',
            'phone' =>'required',
            'address' =>'required|string|max:500',
            'salary' =>'required|nullable|numeric',
            'categories_id' =>'required',
            'status' =>'required|in:1,0',
        ];


    }

}
