<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sale_package_id');
            $table->integer('item_id');
            $table->integer('stock_id');
            $table->double('quantity');
            $table->unsignedInteger('item_unit_id');
            $table->unsignedInteger('no_of_jar')->default(0);
            $table->unsignedInteger('no_of_drum')->default(0);
            $table->unsignedInteger('no_of_jar_return')->default(0);
            $table->unsignedInteger('no_of_drum_return')->default(0);
            $table->double('unit_price');
            $table->double('total_price');
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
        Schema::dropIfExists('sales');
    }
}
