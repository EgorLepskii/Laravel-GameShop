<?php
/**
 * @var \App\Models\FrontProduct $product
 */

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
    <title>{{$product->getName()}} - ГеймсМаркет</title>
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
   @include('layouts.mainHeader')
    <div class="middle">
        <div class="sidebar">
            @include('layouts.category')

            @include('layouts.lastNews')

        </div>
        <div class="main-content">
            <div class="content-top">
                <div class="content-top__text">Купить игры неборого без регистрации смс с торента, получить компкт диск, скачать Steam игры после оплаты</div>
                <div class="image-container"><img src="{{asset('img/slider.png')}}" alt="Image" class="image-main"></div>
            </div>
            <div class="content-middle">
                <div class="content-head__container">
                    <div class="content-head__title-wrap">
                        <div class="content-head__title-wrap__title bcg-title">{{$product->name}} в разделе {{$product->category()->first()->name}}</div>
                    </div>

                </div>
                <div class="content-main__container">
                    <div class="product-container">
                        <div class="product-container__image-wrap"><img src="{{asset('public')."/".$product->getImageSrc()}}" class="image-wrap__image-product"></div>
                        <div class="product-container__content-text">
                            <div class="product-container__content-text__title">{{$product->getName()}}</div>
                            <div class="product-container__content-text__price">
                                <div class="product-container__content-text__price__value">
                                    {{__('mainPage.priceText')}}: <b>{{$product->getPrice()}}</b>
                                    {{__('mainPage.priceType')}}
                                </div>

                                <form action="{{route('order.store',['product' => $product->getId()])}}" method="post">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{$product->getId()}}">
                                    <input type="submit" class="putToBasketBtn" value="{{__('mainPage.putToBasket')}}">
                                </form>

                            </div>
                            <div class="product-container__content-text__description">
                                <p>
                                    {{$product->getDescription()}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-bottom">
                <div class="line"></div>
                <div class="content-head__container">
                    <div class="content-head__title-wrap">
                    </div>
                </div>
                <div class="content-main__container">
                    <div class="products-columns">
                    </div>
                </div>
            </div>
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
<script src="{{asset('js/callbackMenu.js')}}"></script>
<script src="{{ asset('js/main.js') }}"></script></body>

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
</style>
</html>
