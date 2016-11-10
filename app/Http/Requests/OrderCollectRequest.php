<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCollectRequest extends FormRequest
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
            'product' => 'sometimes|required|numeric',
            'variation_id' => 'sometimes|required|numeric',
            'variation_thickness' => 'sometimes|required|numeric',
            'variation_density' => 'sometimes|required|numeric',
            'address1' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'variation_thickness.required' => 'Thickness is required',
            'variation_density.required' => 'Density is required',
            'variation_thickness.numeric' => 'Must be a number',
            'variation_density.numeric' => 'Must be a number',
            'address1.required' => 'Address is required',
        ];
    }


}
