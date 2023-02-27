<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class employee_allowancesRequest extends FormRequest
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
            'allowances_id' =>'required',
            'employee_id' => 'required',
            'month_number'=>'required',
            // 'status' =>'required|in:1,0',
        ];

    }

}
