<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('rolesMessages.pageAddMessage')}}</title>
</head>
<body>
<h1>
    {{__('rolesMessages.roleAdditionPageTittle')}}
</h1>
<hr>
<form action="{{route('role.store')}}" method="post">
    @csrf

    <br>
    <input type="text" name="name" placeholder="{{__('rolesMessages.nameInputPlaceholder')}}">
    <br>
    <p style="color: white;">{{$errors->first('name')}}</p>
    <br>
    <input type="submit" value="{{__('rolesMessages.storeRoleButton')}}">
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
        margin-top: 10px;
    }
</style>
</html>
