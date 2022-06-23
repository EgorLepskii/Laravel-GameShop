<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\FrontUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private \Illuminate\Validation\Factory $validationFactory;

    private \Illuminate\Contracts\Hashing\Hasher $hasher;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\Illuminate\Validation\Factory $validationFactory, \Illuminate\Contracts\Hashing\Hasher $hasher)
    {
        $this->middleware('guest');
        $this->validationFactory = $validationFactory;
        $this->hasher = $hasher;
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return $this->validationFactory->make($data, [
        'name' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): \App\Models\FrontUser
    {
        return FrontUser::create(
            [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hasher->make($data['password']),
            ]
        );
    }
}
