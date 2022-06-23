<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Symfony\Component\Translation\t;

class CategoryDeleteRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [

            'id' => 'required|exists:categories,id'

        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return
            [
                'required' => 'Данное поле не может быть пустым',
                'exist' => 'Такое значение уже существует'

            ];
    }
}
