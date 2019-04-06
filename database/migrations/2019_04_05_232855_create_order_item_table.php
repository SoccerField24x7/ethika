<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->integer('line_number');
            $table->string('name', 75);
            $table->integer('quantity');
            $table->timestamps();
            $table->unique(['order_id', 'line_number']);
            $table->foreign('order_id')->references('id')->on('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* you must release the foreign key before dropping the table */
        Schema::table('order_item', function(Blueprint $table) {
            $table->dropForeign('order_item_order_id_foreign');
        });

        Schema::dropIfExists('order_item');
    }
}
