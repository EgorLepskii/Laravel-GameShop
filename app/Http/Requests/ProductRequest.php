<?php

namespace App\Http\Requests;

use App\Models\FrontProduct;
use Faker\Factory;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Lang;
use function Symfony\Component\Translation\t;

class ProductRequest extends FormRequest
{
    private \Illuminate\Translation\Translator $translator;
    public function __construct(\Illuminate\Translation\Translator $translator)
    {
        $this->translator = $translator;
        parent::__construct();
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
     * @return array<string, mixed[]>
     */
    public function rules(): array
    {
        return [

            'name' => sprintf('required|string|max:%s|unique:products,name', FrontProduct::MAX_NAME_LENGTH),
            'description' => sprintf('required|max:%s', FrontProduct::MAX_DESCRIPTION_LENGTH),
            'price' => sprintf('required|numeric|max:%s', FrontProduct::MAX_PRICE),
            'categoryId' => 'required|exists:categories,id',
            'image' => sprintf('required|image|mimes:jpeg,png,jpg|max:%s', FrontProduct::MAX_IMAGE_SIZE)
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return
            [
                'required' => $this->translator->get('productValidationErrors.emptyField'),
                'max' => $this->translator->get('productValidationErrors.overValue'),
                'image' => $this->translator->get('productValidationErrors.incorrectImage'),
                'mimes' => $this->translator->get('productValidationErrors.incorrectImageType'),
                'string' => $this->translator->get('productValidationErrors.incorrectString'),
                'numeric' => $this->translator->get('productValidationErrors.incorrectFloat'),
                'unique' => $this->translator->get('productValidationErrors.entryAlreadyExists'),
                'exists' => $this->translator->get('productValidationErrors.entryNotExists')
            ];
    }
}
