<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderProductIdToProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger("order_product_id")->nullable();

            $table->foreign('order_product_id')
                ->references('id')
                ->on('order_products')
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
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropForeign(['order_product_id']);
            $table->dropColumn("order_product_id");
        });
    }
}
