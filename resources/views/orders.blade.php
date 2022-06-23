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
    <title>ГеймсМаркет</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
                <div class="content-top__text">Купить игры неборого без регистрации смс с торента, получить компкт диск,
                    скачать Steam игры после оплаты
                </div>
                <div class="slider"><img src="{{asset('img/slider.png')}}" alt="Image" class="image-main"></div>
            </div>
            <div class="content-middle">
                <div class="content-head__container">
                    <div class="content-head__title-wrap">
                        <div class="content-head__title-wrap__title bcg-title">{{__('mainPage.myOrdersText')}}</div>
                    </div>
                    <div class="content-head__search-block">
                        <div class="search-container">

                        </div>
                    </div>
                </div>
                <div class="content-main__container">
                    <div class="cart-product-list">

                        @auth
                            @foreach($orders as $order)

                                <div class="cart-product-list__item">

                                    <div class="cart-product__item__product-photo">
                                        <img src="{{asset('public')."/".$order->product->imageSrc}}"
                                             class="cart-product__item__product-photo__image">
                                    </div>

                                    <div class="cart-product__item__product-name">
                                        <div class="cart-product__item__product-name__content">
                                            <a href="{{route('product.show',['product' => $order->product['id']])}}">
                                                {{$order->product['name']}}</a>
                                            <form
                                                action="{{route('order.destroy', ['order' => $order->getAttribute('id')])}}"
                                                method="post">
                                                @csrf

                                                <input type="hidden" name="orderId"
                                                       value="{{$order->getAttribute('id')}}">

                                                <input type="submit" value="{{__('mainPage.deleteBtnText')}}" id="orderDelete">

                                            </form>
                                        </div>

                                    </div>
                                    <div class="cart-product__item__cart-date">
                                        <div
                                            class="cart-product__item__cart-date__content">{{$order['created_at']}}</div>
                                    </div>
                                    <div class="cart-product__item__product-price"><span
                                            class="product-price__value">{{$order->product['price']}}</span></div>

                                </div>

                            @endforeach

                        @endif


                        <div style="margin-left: 70%">
                        @include('layouts.priceSum')
                        </div>

                        <form action="{{route('buy.store')}}" method="post" style="margin-left: 88%">
                            @csrf
                            <input type="submit" value="{{__('mainPage.buyButton')}}" class="buyBtn">
                        </form>
                    </div>

                </div>
                <div class="content-footer__container">
                    <ul class="page-nav">

                        @for($i = 1; $i <= $count; $i++)
                            <li class="page-nav__item"><a href="{{route('order.index',['page' => $i])}}"
                                                          class="page-nav__item__link">{{$i}}</a></li>
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
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i
                            class="fa fa-facebook"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i
                            class="fa fa-twitter"></i></a></li>
                <li class="social-block__list__item"><a href="#" class="social-block__list__item__link"><i
                            class="fa fa-instagram"></i></a></li>
            </ul>
        </div>
    </footer>
</div>
<style>
    #orderDelete {
        background: rgba(0, 0, 0, 0);
        border: 1px solid red;
        color: red;
        margin-right: 20px;
        font-size: 15px;
    }

    #orderDelete:hover {
        color: black;
        border-color: black;
        cursor: pointer;
    }

    .buyBtn{
        background: #5096D9;
        color: white;
        border:none;
        width: 100px;
        height: 50px;
        cursor: pointer;
    }

    .buyBtn:hover{
        opacity: .8;
    }
</style>
<script src="js/main.js"></script>
</body>
</html>
