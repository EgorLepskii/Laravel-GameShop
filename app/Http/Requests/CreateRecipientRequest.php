<?php

namespace App\Http\Requests;

use App\Models\Recipient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class CreateRecipientRequest extends FormRequest
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
            'email' => sprintf('required|email|max:%s|unique:recipients,email', Recipient::MAX_EMAIL_LENGTH),
            'roleId' => 'required|int|exists:roles,id'
        ];
    }

    public function messages()
    {
        return
            [
                'unique' => $this->translator->get('RecipientValidationErrors.emailExists', ['email' => $this->request->get('email')]),
                'exists' => $this->translator->get('RecipientValidationErrors.roleNotExists'),
                'required' => $this->translator->get('RecipientValidationErrors.emptyField')
            ];
    }


}
