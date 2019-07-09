<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id')->index();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
            $table->tinyInteger('stock_place');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('item_unit_id');
            $table->double('quantity');
            $table->unsignedInteger('no_of_jar')->default(0);
            $table->unsignedInteger('no_of_drum')->default(0);
            $table->double('sold')->default(0);
            $table->double('price');
            $table->double('sale_price')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->date('stock_date')->default(now()->format('Y-m-d'));
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
        Schema::dropIfExists('stocks');
    }
}
