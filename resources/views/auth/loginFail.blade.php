<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>




@foreach($errors as $key => $error)
    <p style="color: red;font-family: sans-serif;">{{$error[0]}}</p>
@endforeach

<style>
    body{
        background: #1a202c;
    }
</style>
</body>
</html>
