<h1>{{__('product.addPageTittle')}}</h1>
<hr>
<div class="panel_row">
    <div class="panel_column">
        <form action="{{route('product.store')}}" enctype="multipart/form-data" method="post">
            @csrf

            <input type="text" name="name" placeholder="{{__('product.nameInput')}}"><br>
            <p class="error">{{$errors->first('name')}}</p><br>
            <textarea type="text" name="description" placeholder="{{__('product.descriptionInput')}}"></textarea><br>
            <p class="error">{{$errors->first('description')}}</p><br>


            <select  name="categoryId">
                @foreach($categories as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>

            <br>

            <input type="text" name="price" placeholder="{{__('product.priceInput')}}"><br>
            <p class="error">{{$errors->first('price')}}<br></p>

            <input type="file" name="image" style="color: white;"><br>
            <p class="error">{{$errors->first('image')}}</p><br>

            <input type="submit" value="{{__('product.saveButton')}}"><br>
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


