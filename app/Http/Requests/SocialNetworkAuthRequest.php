<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialNetworkAuthRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'socialNetwork' => 'required|exists:social_network_types,name'
        ];
    }
}
