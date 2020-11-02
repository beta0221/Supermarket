<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->enum('discount_type',['amount','dicimal']);
            $table->decimal('reduction');
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specific_prices');
    }
}
