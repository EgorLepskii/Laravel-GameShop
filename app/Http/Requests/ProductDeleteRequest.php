<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Symfony\Component\Translation\t;

class ProductDeleteRequest extends FormRequest
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
     * @return mixed[]
     */
    public function rules(): array
    {
        return [


        ];
    }


}
