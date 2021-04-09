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
        Payment::create(['id'=>1,'name'=>'信用卡']);
        Payment::create(['id'=>2,'name'=>'ATM']);
        Payment::create(['id'=>3,'name'=>'貨到付款']);
    }
}
