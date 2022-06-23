<h1>{{__('adminMessages.adminPanelTittle')}}</h1>
<hr>

<a href="{{route('adminProduct.show')}}">{{__('adminMessages.addProduct')}}</a><br>
<a href="{{route('adminCategory.show')}}">{{__('adminMessages.addCategory')}}</a><br>
<a href="{{route('adminRecipient.show')}}">{{__('adminMessages.addRecipient')}}</a><br>


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
</style>




