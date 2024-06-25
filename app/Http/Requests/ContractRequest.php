<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric',
            'installments_number' => 'required|integer',
            'start_date' => 'required|date',
            'payment_frequency' => 'required|string|in:WEEKLY,FORTNIGHTLY,MONTHLY',
            'percentage' => 'required|numeric',
            'payment_day_of_week' => 'required_if:payment_frequency,WEEKLY|nullable|integer|min:0|max:6',
        ];
    }


    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    
    public function messages()
    {
        return [
            'payment_day_of_week.required_if' => 'El campo Dia de Pago es requerido cuando la Frecuencia de Pago es Semanal.',
        ];
    }

}
