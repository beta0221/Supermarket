<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->tinyInteger('priority')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('highlight')->default(0);
            $table->integer('minimum_total')->nullable();
            $table->integer('minimum_amount')->default(0);
            $table->tinyInteger('free_delivery')->default(0);
            $table->integer('total_available')->default(0);
            $table->integer('total_available_each_user')->default(0);
            $table->string('promo_label')->nullable();
            $table->string('promo_text')->nullable();
            $table->integer('multiply_gift')->nullable();
            $table->integer('min_nr_products')->nullable();
            $table->enum('discount_type',['amount','dicimal']);
            $table->decimal('reduction_amount')->nullable();
            $table->integer('gift_product_id')->nullable();
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
        Schema::dropIfExists('cart_rules');
    }
}
