<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpendingRequest extends FormRequest
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
            'list_spending.*.spending_name' =>'required|string|max:100',
            'list_spending.*.section_id'=>'required|exists:sections,id',
            'list_spending.*.month'=>'required|date_format:Y-m-d',
            'list_spending.*.spending_value'=>'required|min:0|numeric',
        ];
    }



}
