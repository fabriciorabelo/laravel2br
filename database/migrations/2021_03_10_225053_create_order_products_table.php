<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float("price", 8, 2)->default(0);
            $table->float("discount", 8, 2)->default(0);
            $table->float("discount_price", 8, 2)->default(0);
            $table->bigInteger("amount")->default(0);
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("order_id");

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('order_products');
    }
}
