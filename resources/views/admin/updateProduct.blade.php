<p>Обновить</p>

<form action="{{route('updateProduct')}}" enctype="multipart/form-data" method="post">
    @csrf

    <input type="hidden" placeholder="идентификатор товара" name="productId" value="{{$id}}">
    <br>
    <input type="text" name="name" placeholder="название товара"><br>
    {{$errors->first('name')}}<br>
    <textarea type="text" name="description" placeholder="описание товара"></textarea><br>
    {{$errors->first('description')}}<br>


    <select  name="category[]">
        @foreach($categories as $category)
            <option value="{{$category['id']}}">{{$category['name']}}</option>
        @endforeach
    </select>

    <br>

    <input type="text" name="price" placeholder="цена"><br>
    {{$errors->first('price')}}<br>

    <input type="file" name="image"><br>
    {{$errors->first('image')}}<br>

    <input type="submit"><br>
</form>
