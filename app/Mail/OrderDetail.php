<?php

namespace App\Mail;

use App\Order;
use App\Http\Resources\OrderResource;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetail extends Mailable
{

    //public property for view
    public $OR;


    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_numero)
    {
        $order = Order::where('order_numero',$order_numero)->firstOrFail();
        $this->OR = new OrderResource($order);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mail_orderDetail');
    }
}
