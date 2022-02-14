<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PointRequest extends FormRequest
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
            'id' => 'sometimes|nullable|integer|exists:points,id',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'router' => 'sometimes|nullable|string|max:50',
            'is_active' => 'required|integer',
            'lan_ip' => 'sometimes|nullable|string|max:15',
            'vpn_ip' => 'sometimes|nullable|string|max:15',
            'wan_ip' => 'sometimes|nullable|string',
            'telephony_status' => 'integer',
            'provider' => 'sometimes|nullable|string|max:250',
            'login' => 'sometimes|nullable|string|max:30',
            'password' => 'sometimes|nullable|string|max:20',
            'ups' => 'sometimes|nullable|string|max:250',
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
            'city' => 'Город',
            'address' => 'Адрес',
            'router' => 'Роутер',
            'is_active' => 'Активная точка',
            'lan_ip' => 'LAN IP Адрес',
            'vpn_ip' => 'Адрес VPN',
            'wan_ip' => 'Адрес WAN IP',
            'telephony_status' => 'Статус телефонии',
            'provider' => 'Провайдер',
            'login' => 'Логин',
            'password' => 'Пароль',
            'ups' => 'УПС',
        ];
    }
}
