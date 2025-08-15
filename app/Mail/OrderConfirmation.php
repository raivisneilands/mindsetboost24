<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

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
                    ->markdown('emails.order-confirmation')
                    ->with([
                        'order' => $this->order,
                        'product' => $this->product,
                    ]);
    }
}
