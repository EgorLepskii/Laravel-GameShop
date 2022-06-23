<h1>{{__('categories.pageTittle')}}</h1>
<hr>
<div class="panel_row">
    <div class="panel_column">
        <form action="{{route('category.create')}}" method="post">

            @csrf
            <input type="text" name="name" placeholder="{{__('categories.nameInputField')}}"><br>
            <p style="color: white;">{{$errors->first('name')}}</p><br>

            <input type="submit" value="{{__('categories.saveButton')}}"><br>
        </form>
    </div>
</div>

<style>
    body{
        background: #1a202c;
        font-family: sans-serif;
    }

    h1{
        color: white;
    }
</style>
