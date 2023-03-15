<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchooleRequest extends FormRequest
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
            'school_id' =>'required',
            'name' =>'required',
            'email' => 'required|email|unique:school_teachers,email,'.$this -> id,
            'phone' =>'required|max:100|unique:school_teachers,phone,'.$this -> id,
            'address' =>'required|string|max:500',
            'salary' =>'required|nullable|numeric',
            'categories_id' =>'required|exists:school_categories,id',
            'month'=>'required|date_format:Y-m-d',
            'data'=>'required',
        ];

    }

}
