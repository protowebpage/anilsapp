<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable2 extends Migration
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
            $table->timestamps();

            // $table->bigInteger('spec_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->bigInteger('address_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('variation_id')->unsigned();
            $table->string('file', 256);
            $table->text('comment');

            // $table->foreign('spec_id')
            //     ->references('id')
            //     ->on('specs');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');

            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('variation_id')
                ->references('id')
                ->on('variations');

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
