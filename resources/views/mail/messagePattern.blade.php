<?php
/**
 * @var \App\Models\FrontProduct $product
 * @var \App\Models\FrontUser $user
 */
?>

{{__('mailMessages.userName')}}: {{$user->getAttribute('name')}}
<br>
{{__('mailMessages.userEmail')}}: {{$user->getAttribute('email')}}
<br>


@foreach($products as $product)
    <hr>
    {{__('mailMessages.productName')}}: {{$product->getName()}}
    <br>
    {{__('mailMessages.productId')}}: {{$product->getId()}}
    <br>
    {{__('mailMessages.productPrice')}}: {{$product->getPrice()}}
    <br>
    {{__('mailMessages.productName')}}: {{$product->getName()}}
    <br>
@endforeach

<hr>
{{__('mailMessages.totalPrice')}}: {{$totalPrice}} {{__('mainPage.priceType')}}

