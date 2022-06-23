<?php

/**
 * @var FrontUser $user
 */

use App\Models\FrontUser;


?>

<header class="main-header">
    <div class="logotype-container"><a href="#" class="logotype-link"><img src="{{ asset('img/logo.png') }}" alt="Логотип"></a></div>
    <nav class="main-navigation">
        <ul class="nav-list">
            <li class="nav-list__item"><a href="{{route('home.index')}}" class="nav-list__item__link">
                    {{__('mainPage.mainHeaderText')}}
                </a></li>
            <li class="nav-list__item"><a href="{{route('order.index')}}" class="nav-list__item__link">
                    {{__('mainPage.myOrdersText')}}
                </a></li>
            <li class="nav-list__item"><a href="#" class="nav-list__item__link">{{__('mainPage.newsText')}}</a></li>
            <li class="nav-list__item"><a href="#" class="nav-list__item__link">{{__('mainPage.aboutCompanyText')}}</a></li>
        </ul>
    </nav>
    <div class="header-contact">
        <div class="header-contact__phone"><a href="#" class="header-contact__phone-link">{{__('mainPage.phoneText')}}: 33-333-33</a></div>
    </div>
    <div class="header-container">
        <div class="payment-container">
            <div class="payment-basket__status">
                <div class="payment-basket__status__icon-block"><a class="payment-basket__status__icon-block__link"><i class="fa fa-shopping-basket"></i></a></div>
                @include('layouts.userProductsCount')
            </div>
        </div>
        <div class="authorization-block">
            @auth

                {{Auth::user()->name}}
            <br>

                @if(Auth::user()->isAdmin)
                    <a href="{{route('admin.show')}}" class="admin-link">{{__('mainPage.adminText')}}</a>
                    <br>
                @endif
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <input type="submit" value="выйти" class="logout-btn">
                </form>

            @else
                <a href="{{route('register')}}" class="authorization-block__link">{{__('mainPage.registerText')}}</a>
                <a href="{{route('login')}}" class="authorization-block__link">{{__('mainPage.authorizationText')}}</a>

            @endif
        </div>
    </div>
</header>

<style>

    .putToBasketBtn{
        width: 100px;
        height: 30px;
        background: #5096D9;
        color: white;
        cursor: pointer;
        border:none;
    }

    .putToBasketBtn:hover {
        opacity: .8;
    }

    .admin-link
    {
        color: darkgreen;
        text-decoration: navajowhite;
        font-size: 10px;
    }

    .admin-link:hover
    {
        text-decoration: underline;
    }

    .logout-btn{
        background: rgba(0,0,0,0);
        border: none;
        color: red;
        cursor: pointer;padding: 0;
        font-size: 10px;
    }

    .logout-btn:hover
    {
        color: white;
    }
</style>
