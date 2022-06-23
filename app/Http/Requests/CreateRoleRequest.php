<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class CreateRoleRequest extends FormRequest
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
            'name' => sprintf('required|max:%s|unique:roles,name', Role::MAX_NAME_LENGTH)
        ];
    }

    public function messages()
    {
        return [
            'required' => $this->translator->get('roleValidationErrors.emptyField'),
            'unique' => $this->translator->get('roleValidationErrors.nameExists')
        ];
    }
}
