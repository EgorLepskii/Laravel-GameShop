<?php

namespace App\Mail;

use App\Models\FrontUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderMail  extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected FrontUser $user;

    protected array $products;

    protected int $totalPrice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FrontUser $user, array $products, int $totalPrice)
    {
        $this->user = $user;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
            ->view(
                'mail.messagePattern',
                [
                    'products' => $this->products,
                    'user' => $this->user,
                    'totalPrice' => $this->totalPrice
                ]
            );
    }




}
