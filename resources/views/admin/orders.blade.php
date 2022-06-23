@foreach($orders as $order)
    <div class="order">
    Название заказа: {{$order['name']}}<br>
    Email заказчика: {{$order['email']}}<br>
    Дата заказа: {{$order['order_date']}}<br>
    <img src="{{asset('storage')."/".$order['image_src']}}" style="width: 200px;height: 100px;"><br>

    </div>
@endforeach


<style>
    body
    {
        font-family: sans-serif;
    }
    .order
    {
        width: 400px;
        height: 200px;
        border: 1px solid black;
        margin-top: 10px;
        padding: 20px;
    }

</style>
