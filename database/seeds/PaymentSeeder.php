<?php

use App\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create(['name'=>'信用卡']);
        Payment::create(['name'=>'ATM']);
        Payment::create(['name'=>'貨到付款']);
    }
}
