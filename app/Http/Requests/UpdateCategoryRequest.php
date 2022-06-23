<?php

namespace App\Http\Requests;

use App\Models\FrontCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UpdateCategoryRequest extends FormRequest
{
    private \Illuminate\Translation\Translator $translator;
    public function __construct(\Illuminate\Translation\Translator $translator)
    {
        $this->translator = $translator;
        parent::__construct();
    }
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
            'name' => sprintf('required|max:%s|unique:categories,name', FrontCategory::MAX_NAME_LENGTH)
        ];
    }

    public function messages()
    {
        return [
            'unique' => $this->translator->get('categoriesValidationErrors.nameAlreadyExists'),
            'required' => $this->translator->get('categoriesValidationErrors.emptyField')
        ];
    }
}
