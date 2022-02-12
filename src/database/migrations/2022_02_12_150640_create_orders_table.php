<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('status');
            $table->text('items');
            $table->string('address');
            $table->decimal('delivery_price', 9, 3);
            $table->decimal('items_price', 9, 3);
            $table->decimal('total', 9, 3);
            $table->dateTime('expected_delivery');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('set null');
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
};
