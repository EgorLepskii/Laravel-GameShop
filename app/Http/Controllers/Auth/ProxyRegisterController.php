<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProxyRegisterController extends RegisterController
{
    public function proxyCreate(array $data): void
    {
        $this->create($data);
    }

    public function proxyValidate(array $data): void
    {
        $this->validator($data);
    }
}
