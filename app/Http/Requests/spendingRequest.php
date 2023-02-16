<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class spendingRequest extends FormRequest
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
            'list_spending.*.spending_name' =>'required',
            // 'spending_name'=>'required',
            // 'section_id'=>'required',
            // 'spending_name'=>'required',
            // 'month'=>'required',
            // 'spending_value'=>'required',
        ];
    }



}
