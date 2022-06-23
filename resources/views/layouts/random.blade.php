<?php
/**
 * @var FrontProduct $product
 */

use App\Models\FrontProduct;

?>

<div class="random-product-container">
    <div class="random-product-container__head">{{__('mainPage.randomProductText')}}</div>
    <div class="random-product-container__content">
        <div class="item-product">
            <div class="item-product__title-product"><a href="#" class="item-product__title-product__link">{{$product->getName()}}</a></div>
            <div class="item-product__thumbnail"><a href="#" class="item-product__thumbnail__link"><img src="{{asset('public')."/".$product->getImageSrc()}}" alt="Preview-image" class="item-product__thumbnail__link__img"></a></div>
            <div class="item-product__description">
                <div class="item-product__description__products-price"><span class="products-price">{{$product->getPrice()}} {{__('mainPage.priceType')}}</span></div>
                <div class="item-product__description__btn-block">

                    <form action="{{route('order.store',['product' => $product->getId()])}}" method="post">
                        @csrf
                        <input type="hidden" name="productId" value="{{$product->getId()}}">
                        <input type="submit" class="putToBasketBtn" value="{{__('mainPage.putToBasket')}}">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
