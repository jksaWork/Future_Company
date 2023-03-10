<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnersRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'email|unique:owners,email',
            'phone' => 'required|numeric',
            'identification_number' => 'required',
            'identification_type' => 'required',
            'workplace' => 'required',
        ];
        // dd(request()->email);
        if(request()->method() == 'PUT'){
            $roles['email'] = 'exists:owners,email';
        }
        // dd($email);
        return $roles;
    }
}
