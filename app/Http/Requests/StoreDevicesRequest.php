<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevicesRequest extends FormRequest
{
    //protected $stopOnFirstFailure = true;
    
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
            'status'=>'required',
            'displacement'=>'required',
            'type_brake'=>'required',
            'reference'=>'required',
            'licence_plate'=>'required',
            'model'=>'required',
            'status'=>'required',
        ];
    }
}
