<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('status_id')->default(1);
            $table->integer('carrier_id');
            $table->integer('payment_id');
            $table->integer('shipping_address_id');
            $table->integer('billing_address_id');
            $table->integer('billing_company_id')->nullable();
            $table->integer('currency_id');
            $table->mediumText('comment')->nullable();
            $table->string('shipping_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->dateTime('invoice_date')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->decimal('total_discount');
            $table->decimal('total_discount_tax');
            $table->decimal('total_shipping');
            $table->decimal('total_shipping_tax');
            $table->decimal('total');
            $table->decimal('total_tax');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
