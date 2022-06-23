<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

use function Symfony\Component\Translation\t;

class CreateOrderRequest extends FormRequest
{
    private \Illuminate\Contracts\Auth\Guard $guard;
    private \Illuminate\Translation\Translator $translator;
    public function __construct(\Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Translation\Translator $translator)
    {
        $this->guard = $guard;
        parent::__construct();
        $this->translator = $translator;
    }
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
     * @return array<string, array<string|\Illuminate\Validation\Rules\Unique>>
     */
    public function rules(): array
    {

        return [

            'productId' => ['required', 'int', 'exists:products,id', Rule::unique('orders', 'productId')
                ->where('userId', $this->guard->id())],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return
            [
                'required' => $this->translator->get('orderMessages.emptyField'),
                'unique' => $this->translator->get('orderMessages.alreadyExists')
            ];
    }
}
