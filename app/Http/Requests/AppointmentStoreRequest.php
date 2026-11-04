<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'barber_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_time' => 'required|date|after:now',
        ];
    }

    
    public function messages()
    {
        return [
            'required' => 'Обязательное поле',
            'exists' => 'Не существующий :attribute',
        ];
    }

    public function attributes(): array
    {
        return [
            'barber_id' => 'барбер',
            'service_id' => 'услуга',
            'appointment_time' => 'время записи',
        ];
    }
}
