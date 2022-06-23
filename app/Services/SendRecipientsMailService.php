<?php

namespace App\Services;

use App\Mail\OrderMail;
use App\Models\Recipient;
use App\Models\FrontUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SendRecipientsMailService
{
    protected Recipient $recipient;


    /**
     * Send information about products to order recipients
     *
     * @param  Collection $recipients
     * @param  FrontUser  $user
     * @param  array      $products
     * @param  int        $totalPrice
     * @return void
     */
    public function send(Collection $recipients, FrontUser $user, array $products, int $totalPrice)
    {
        foreach ($recipients as $recipient) {
            $this->recipient = $recipient;

            Mail::to($this->recipient->getAttribute('email'))->queue(
                new OrderMail(
                    $user,
                    $products,
                    $totalPrice
                )
            );
        }

    }
}
