<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_no')->index();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('customer_id')->index();
            $table->unsignedInteger('vehicle_id')->nullable()->index();
            $table->string('journey_from')->nullable();
            $table->string('journey_to')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('sale_packages');
    }
}
