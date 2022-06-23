<?php

namespace App\Http\Requests;

use App\Models\Recipient;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipientRequest extends FormRequest
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
    public function rules()
    {
        return [
            'email' => sprintf('required|email|max:%s', Recipient::MAX_EMAIL_LENGTH),
            'orderId' => 'required|int|exists:orders,id',
            'roleId' => 'required|int|exists:roles,id'
        ];
    }
}
