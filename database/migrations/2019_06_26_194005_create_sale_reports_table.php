<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sale_package_id');
            $table->foreign('sale_package_id')->references('id')->on('sale_packages')->onDelete('cascade');
            $table->unsignedInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_mobile_no',20);
            $table->unsignedInteger('item_id');
            $table->string('item_name');
            $table->unsignedInteger('stock_id');
            $table->double('quantity');
            $table->unsignedInteger('item_unit_id');
            $table->string('item_unit');
            $table->unsignedInteger('no_of_jar');
            $table->unsignedInteger('no_of_drum');
            $table->double('unit_price');
            $table->double('total_price');
            $table->dateTime('sale_datetime');
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
        Schema::dropIfExists('sale_reports');
    }
}
