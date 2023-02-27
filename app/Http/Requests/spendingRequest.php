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
            'spending_name' =>'required|string|max:100',
            'section_id'=>'required|exists:sections,id',
            'month'=>'required|date_format:Y-m-d',
            'spending_value'=>'required|min:0|numeric',
        ];
    }



}
