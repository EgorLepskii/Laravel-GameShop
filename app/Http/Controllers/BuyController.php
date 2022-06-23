<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderRecipientRole;
use App\Models\Recipient;
use App\Models\FrontUser;
use App\Models\User;
use App\Services\SendRecipientsMailService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;


class BuyController extends Controller
{
    protected User $user;

    protected Order $order;

    protected Recipient $recipient;

    protected OrderRecipientRole $role;

    private \Illuminate\Contracts\Auth\Guard $guard;

    private \Illuminate\Routing\Redirector $redirector;

    private \Illuminate\Translation\Translator $translator;

    public function __construct(\Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Routing\Redirector $redirector, \Illuminate\Translation\Translator $translator)
    {
        $this->guard = $guard;
        $this->redirector = $redirector;
        $this->translator = $translator;
    }

    /**
     * Send information about user orders to order recipients and delete all user orders
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function store(): \Illuminate\Http\RedirectResponse
    {
        $this->user = $this->guard->user() ?? new FrontUser();
        $products = $this->user->products();

        if (empty($products)) {
            return $this->redirector->route('order.index')->withErrors(['products' => $this->translator->get('productValidationErrors.emptyOrders')]);
        }

        $totalPrice = Order::getGeneralPrice($this->user->getAuthIdentifier());
        $this->role = OrderRecipientRole::get() ?? new OrderRecipientRole();
        $recipients = $this->role->recipients()->get();

        $sendService = new SendRecipientsMailService();
        $sendService->send($recipients, $this->user, $products, $totalPrice);

        $this->user->orders()->delete();

        return $this->redirector->to('/');

    }
}
