<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteOrderRequest extends FormRequest
{
    private \Illuminate\Contracts\Auth\Guard $guard;
    public function __construct(\Illuminate\Contracts\Auth\Guard $guard)
    {
        $this->guard = $guard;
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
        $userId = $this->guard->user() == null ? -1 : $this->guard->user()->getAuthIdentifier();
        return [
            'orderId' =>
                [
                    'required',
                    'int',
                    Rule::exists('orders', 'id')->where('userId', $userId)
                ]
        ];
    }

    public function messages()
    {
        return
            [
                'userId' => 'FrontUser credentials does not match'
            ];
    }
}
