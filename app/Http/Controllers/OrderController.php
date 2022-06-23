<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DeleteOrderRequest;
use App\Models\Order;
use App\Models\FrontProduct;
use App\Models\FrontUser;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use phpDocumentor\Reflection\DocBlock\Tags\Author;
use function view;


/**
 * Controller for working with orders
 */
class OrderController extends Controller
{

    protected User $user;

    private \Illuminate\Contracts\Auth\Guard $guard;

    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Routing\UrlGenerator $urlGenerator;

    public function __construct(\Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Routing\Redirector $redirector, \Illuminate\Routing\UrlGenerator $urlGenerator)
    {
        $this->guard = $guard;
        $this->viewFactory = $viewFactory;
        $this->redirector = $redirector;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Receive all user orders
     *
     * @return Application|Factory|\Illuminate\Support\Facades\View
     */
    public function index(int $page = 1): \Illuminate\Contracts\View\View
    {
        $this->user = $this->guard->user() ?? new FrontUser();
        $userId = $this->user->getAttribute('id');

        $generalOrdersCount = Order::query()->where('userId', '=', $userId)->get()->count();

        $orders = Order::query()
            ->where('userId', '=', $userId)
            ->offset(($page - 1) * Order::MAX_ORDERS_SHOW_COUNT)
            ->limit(Order::MAX_ORDERS_SHOW_COUNT)
            ->get();

        $showOrdersCount = ceil($generalOrdersCount / Order::MAX_ORDERS_SHOW_COUNT);

        return $this->viewFactory->make('orders', ['orders' => $orders, 'count' => $showOrdersCount]);
    }

    /**
     * Create new order. Order will be saved in database.
     */
    public function store(CreateOrderRequest $createOrderRequest, FrontProduct $product, Order $order): \Illuminate\Http\RedirectResponse
    {

        $order->fill(['userId' => $this->guard->user()->getAuthIdentifier(), 'productId' => $product->getId()]);
        $order->save();

        return $this->redirector->to($this->urlGenerator->route('order.index'));
    }


    /**
     * Delete order
     */
    public function destroy(DeleteOrderRequest $deleteOrderRequest, Order $order): \Illuminate\Http\RedirectResponse
    {
        $order->delete();
        return $this->redirector->to($this->urlGenerator->route('order.index'));
    }
}
