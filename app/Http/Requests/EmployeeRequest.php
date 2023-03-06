<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'email' => 'required|email|unique:employees,email,'.$this -> id,
            'phone' =>'required|max:100|unique:employees,phone,'.$this -> id,
            'address' =>'required|string|max:500',
            'salary' =>'required|nullable|numeric',
            'categories_id' =>'required|exists:categories,id',
            'month'=>'required|date_format:Y-m-d',
            'data'=>'required',
        ];

    }

}
