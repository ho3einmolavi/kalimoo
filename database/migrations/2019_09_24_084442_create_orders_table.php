<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->bigInteger('pay_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->boolean('factor')->nullable()->default(0);
            $table->string('payment_method')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->nullable()->default('در حال بررسی');
            $table->string('total')->nullable();
            $table->bigInteger('delivery_man_id')->nullable();
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
