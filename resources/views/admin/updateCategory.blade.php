<div class="panel_column">
    <p>Обновить</p>

    <form action="{{route('categoryUpdate')}}" enctype="multipart/form-data" method="post">
        @csrf

        <input type="hidden" placeholder="идентификатор категории" name="categoryId" value="{{$id}}">
        <br>
        <input type="text" name="name" placeholder="название категории"><br>
        {{$errors->first('name')}}<br>

        <input type="submit"><br>
    </form>
</div>
