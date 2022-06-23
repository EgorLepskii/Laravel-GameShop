<?php

namespace App\Http\Requests;

use App\Models\FrontUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class EmailAdditionRequest extends FormRequest
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
            'email' => 'required|email'
        ];
    }

    public function messages()
    {
        return [
          'email' => $this->translator->get('auth.failed')
        ];
    }
}
