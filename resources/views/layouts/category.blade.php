<div class="sidebar-item">
    <div class="sidebar-item__title">{{__('mainPage.categoriesText')}}</div>
    <div class="sidebar-item__content">
        <ul class="sidebar-category">
            @foreach($categories as $category)

                <li class="sidebar-category__item">
                    <a href="{{route('home.index',['page' => 1,'category'=>$category->id])}}"
                                                      class="sidebar-category__item__link">{{$category->name}}</a></li>

                @auth
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)
                        <form action="{{route('category.destroy',['category' => $category->id])}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$category->id}}">
                            <input type="submit" value="{{__('mainPage.deleteBtnText')}}" class="delete-product-btn">
                        </form>
                        <a href="{{route('category.edit', ['category' => $category->id])}}" class="update-link">{{__('mainPage.updateText')}}</a>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</div>

<style>
    .update-link
    {
        color: #2ca02c;
        text-decoration: none;
    }

    .update-link:hover
    {
        text-decoration: underline;
    }

    .delete-product-btn
    {
        background: none;
        border: 1px solid red;
        cursor: pointer;
        color: red;
        padding: 5px;
    }

    .delete-product-btn:hover
    {
        background: red;
        color: white;
    }
</style>
