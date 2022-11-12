<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    //protected $redirectRoute= 'users.index';
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'date_of_birth' => 'required|date',
            'type_id_role' => 'required|max:10|min:1',
            'type_id_doc' => 'required|max:1|min:1',
            'id_user' => 'required|unique:users',
        
            'gender' => 'required|string|max:1|min:1',
           
            //
        ];
    }
}
