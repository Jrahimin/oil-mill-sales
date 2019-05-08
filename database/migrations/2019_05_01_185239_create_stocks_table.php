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
            $table->unsignedInteger('item_id')->index();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
            $table->unsignedInteger('user_id');
            $table->integer('no_of_items');
            $table->integer('sold');
            $table->double('price');
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
