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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer|exists:contracts,id',
            'number' => 'required|string|max:255',
            'contracts_master' => 'required|string',
            'speed' => 'nullable|string',
            'price' => 'nullable|string',
            'login_pppoe' => 'nullable|string',
            'password_pppoe' => 'nullable|string',
            'point_id' => 'nullable|integer|exists:points,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'integer' => 'Значение :attribute может быть только числом',
            'exists' => 'Передано несуществующее значение :attribute',
            'string' => 'Значение :attribute может быть только строкой',
        ];
    }

    public function attributes(): array
    {
        return [
            'number' => 'Номер договора',
            'contracts_master' => 'Владелец договора',
            'speed' => 'Скорость подключения',
            'price' => 'Стоимость по договору',
            'login_pppoe' => 'Логин PPPoE',
            'password_pppoe' => 'Пароль PPPoE',
            'point_id' => 'Подразделение',
        ];
    }

}
