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
    // public function rules()
    // {
    //     $roles =  [
    //         // 'name' => 'required|string|max:100',
    //         'email' => 'required|email|unique:employees,email',
    //         // 'phone' => 'required',
    //         // // 'status' => 'required|in:1,0',
    //         // 'phone' => 'required',
    //         // 'salary' => 'required',
    //         // 'address' => 'required',


    //     ];


    //     return $roles;
    // }
    // public function messages()
    // {
    //     return [
    //         'required' => 'هذا الحقل مطلوب',
    //         'in' => 'القيم المدخلة غير صحيحة ',
    //         'name.string' => 'اسم  لابد ان يكون احرف',

    //     ];
    // }
    public function rules()
    {
        return [
            
            'name' =>'required',
            'email' => 'required|email|unique:employees,email',
            'salary' =>'required|integer',
            'status' =>'required',
            'phone' =>'required',
            'address' =>'required',

        ];
    }
}
