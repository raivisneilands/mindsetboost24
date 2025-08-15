<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Order;
use App\Models\Product;

class SendOrderConfirmationEmail extends Mailable
{
    public $order;
    public $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function build()
    {
        return $this->subject('Your Order Confirmation')
                    ->view('emails.order-confirmation');
    }
}

