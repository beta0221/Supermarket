<?php

namespace App\Jobs;

use App\Mail\OrderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $order_numero;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$order_numero)
    {
        $this->email = $email;
        $this->order_numero = $order_numero;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new OrderDetail($this->order_numero));
    }
}
