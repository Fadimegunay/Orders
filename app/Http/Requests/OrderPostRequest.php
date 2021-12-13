<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPostRequest extends FormRequest
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
            'customerId' => 'required',
            'productId' => 'required',
            'quantity' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'customerId.required' => 'A customerId is required',
            'productId.required' => 'A productId is required',
            'quantity.required' => 'A quantity is required',
        ];
    }
}
