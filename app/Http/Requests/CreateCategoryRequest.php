<?php

namespace App\Http\Requests;

use App\Models\FrontCategory;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Lang;
use function Symfony\Component\Translation\t;

class CreateCategoryRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return
            [
                'name' => sprintf("required|max:%s|unique:categories,name", FrontCategory::MAX_NAME_LENGTH),
            ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return
            [
                'required' => $this->translator->get('categoriesValidationErrors.emptyField'),
                'unique' => $this->translator->get('categoriesValidationErrors.nameAlreadyExists')
            ];
    }
}
