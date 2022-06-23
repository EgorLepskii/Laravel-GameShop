<?php
/**
 * @var \App\Models\FrontProduct $product
 */

?>
<div class="content-main__container">
    <div class="products-columns">

        @foreach($products as $product)

            <div class="products-columns__item">
                <div class="products-columns__item__title-product"><a href="{{route('product.show', ['product' => $product->getId()]) }}" class="products-columns__item__title-product__link">{{$product->getName()}}</a></div>
                <div class="products-columns__item__thumbnail"><a href="#" class="products-columns__item__thumbnail__link"><img src="{{asset('public')."/".$product->getImageSrc()}}" alt="Preview-image" class="products-columns__item__thumbnail__img"></a></div>
                <div class="products-columns__item__description"><span class="products-price">{{$product->getPrice()}} {{__('mainPage.priceType')}}</span>

                    <form action="{{route('order.store',['product' => $product->getId()])}}" method="post">
                        @csrf

                        <input type="hidden" name="productId" value="{{$product->getId()}}">
                        <input type="submit" value="{{__('mainPage.putToBasket')}}" class="putToBasketBtn">
                    </form>

                </div>
                @auth()
                    @if(Auth::user()->isAdmin)
                        <form action="{{route('product.destroy', ['product' => $product->getId()])}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$product->getId()}}">
                            <input type="submit" value="{{__('mainPage.deleteBtnText')}}" class="delete-product-btn">
                        </form>

                        <a href="{{route('product.edit',['product'=>$product->getId()])}}" class="update-link">{{__('mainPage.updateText')}}</a>

                    @endif
                @endif
            </div>

        @endforeach


    </div>

</div>

<style>
    .update-link
    {
        color: #2ca02c;
        text-decoration: none;
    }

    .update-link:hover
    {
        text-decoration: underline;
    }

    .delete-product-btn
    {
        background: none;
        border: 1px solid red;
        cursor: pointer;
        color: red;
        padding: 5px;
    }

    .delete-product-btn:hover
    {
        background: red;
        color: white;
    }
</style>
<script>
    import Index from "../../../test/vendor/facade/ignition/resources/compiled/index.html";
    import FooterDescriptionServiceProvider
    import PreventRequestsDuringMaintenance
    export default {
        components: {PreventRequestsDuringMaintenance, FooterDescriptionServiceProvider, Index}
    }
</script>
