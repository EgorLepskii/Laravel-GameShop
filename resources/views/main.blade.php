<?php
/**
 * @var FrontProduct $product
 */

use App\Models\FrontProduct;

?>

@if($errors->any())

    @foreach($errors->all() as $error)
    <script>
        alert("{{$error}}");
    </script>

    @endforeach
@endif
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>main - ГеймсМаркет</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}">
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
</head>
<body>
<div class="main-wrapper">
    <div id="callback">
        <div id="close_callback">&times;</div>
        <div id="callback_form">
        </div>
    </div>

    @include('layouts.mainHeader')

    <div class="middle">

        <div class="sidebar">
            @include('layouts.category')

            @include('layouts.lastNews')


        </div>
        <div class="main-content">
            <div class="content-top">
                <div class="content-top__text">Купить игры недорого без регистрации смс с торента, получить компакт диск, скачать Steam игры после оплаты</div>
                <div class="slider../"><img src="{{asset('img')."/"."slider.png"}}" alt="Image" class="image-main"></div>
            </div>
            <div class="content-middle">
                <div class="content-head__container">
                    <div class="content-head__title-wrap">
                        <div class="content-head__title-wrap__title bcg-title">{{__('mainPage.lastProductsText')}}</div>
                    </div>
                    <div class="content-head__search-block">
                        <div class="search-container">
                                <input type="text" class="search-container__form__input" id="main__search__input">
                                <button  class="search-container__form__btn" id="main__search__btn">{{__('mainPage.searchText')}}</button>
                        </div>
                        <div id="main__search__result">

                        </div>
                    </div>
                </div>
               @include('layouts.products')
                <div class="content-footer__container">
                    <ul class="page-nav">

                        @for($i = 1; $i <= $count; $i++)
                            <li class="page-nav__item"><a href="{{route('home.index',['page' => $i, 'category' => $category])}}" class="page-nav__item__link">{{$i}}</a></li>
                        @endfor
                    </ul>


                </div>
            </div>
            <div class="content-bottom"></div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer__footer-content">

            @include('layouts.random')



           @include('layouts.footerDescription')
        </div>
        <div class="footer__social-block">
            <ul class="social-block__list bcg-social">
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-facebook"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-twitter"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </footer>
</div>
<script  src="{{url('js/app.js')}}"></script>
</body>
</html>
<style>
    #main__search__result
    {
        position: absolute;
        width: 210px;
        background: #cacaca;
        margin-top: 10px;
        padding: 20px;
        border-radius: 10px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        display: none;
    }

    #main__search__result a
    {
        cursor: pointer;
        color: green;
        font-family: sans-serif;
        font-size: 16px;
    }

    #main__search__result a:hover
    {
        text-decoration: none;
        color: white;
    }


</style>
