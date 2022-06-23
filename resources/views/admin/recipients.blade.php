
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('recipientMessages.pageAddMessage')}}</title>
</head>
<body>
<h1>
    {{__('recipientMessages.pageTitle')}}
</h1>
<hr>
<form action="{{route('recipient.store')}}" method="post">
    @csrf

    <br>
    <input type="email" name="email" placeholder="email">
    <br>
    <p style="color: white;">{{$errors->first('email')}}</p>
    <br>
    <select name="roleId">
        @foreach($roles as $role)
            <option value="{{$role->id}}">{{$role->name}}</option>
        @endforeach
    </select>
    <br>
    <p style="color: white;">{{$errors->first('roleId')}}</p>

    <br>
    <input type="submit" value="{{__('recipientMessages.storeRecipientButton')}}">
</form>


</body>
<style>

    h1 {
        color: white;
    }

    body {
        font-family: sans-serif;
        background: #1a202c;
    }

    form input
    {
        background: ;
        margin-top: 10px;
    }
</style>
</html>
