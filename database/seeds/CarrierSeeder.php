<?php

use App\Carrier;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrier::create([
            'name'=>'黑貓宅配',
            'price'=>150,
            'delivery_text'=>'黑貓宅配',
        ]);
    }
}
