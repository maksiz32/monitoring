<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrinterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'id' => 'sometimes|nullable|integer|exists:printers,id',
            'name' => ['required','string','max:255','unique:printers,name'],
            'description' => 'nullable|string',
            'pointId' => 'sometimes|nullable|integer|exists:points,id'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'integer' => 'Значение :attribute может быть только числом',
            'exists' => 'Передано несуществующее значение :attribute',
            'string' => 'Значение :attribute может быть только строкой',
            'unique' => ':attribute уже существует',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Принтер',
            'description' => 'Описание',
            'pointId' => 'Подразделение',
        ];
    }
}
