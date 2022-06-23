<?php
/**
 * @var \App\Models\FrontProduct $product;
 */

?>
<h1>{{__('product.updatePageTittle')}}</h1>
<hr>
<div class="panel_row">
    <div class="panel_column">
        <form action="{{route('product.update',['product' => $product->getId()])}}" enctype="multipart/form-data" method="post">
            @csrf

            <input type="text" name="name" placeholder="{{__('product.nameInput')}}" value="{{$product->getName()}}"><br>
            <p class="error">{{$errors->first('name')}}</p><br>
            <textarea type="text" name="description" placeholder="{{__('product.descriptionInput')}}">
                {{$product->getDescription()}}
            </textarea><br>
            <p class="error">{{$errors->first('description')}}</p><br>


            <select  name="categoryId">
                @foreach($categories as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
            <p class="error">{{$errors->first('categoryId')}}</p><br>


            <br>

            <input type="text" name="price" placeholder="{{__('product.priceInput')}}" value="{{$product->getPrice()}}"><br>
            <p class="error">{{$errors->first('price')}}</p><br>

            <input type="file" name="image" style="color: white;"><br>
            <p class="error">{{$errors->first('image')}}</p><br>

            <input type="submit" value="{{__('product.updateButton')}}"><br>
        </form>
    </div>

    <div class="panel_column">

    </div>
</div>

<style>
    h1
    {
        color: white;
    }
    body{
        background: #1a202c;
        font-family: sans-serif;
    }

    a{
        color: white;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
    }

    a:hover
    {
        color: green;
    }

    .error{
        color: white;
    }
</style>
