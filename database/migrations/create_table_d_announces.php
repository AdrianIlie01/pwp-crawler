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
        Schema::create('announces', function (Blueprint $table) {
            $table->integer('id')->primary();
//            $table->string('car_name')->nullable();
            $table->string('price')->nullable();
//            $table->year('manufacture_year')->nullable();
//            $table->string('mileage_km')->nullable();
//            $table->string('engine_capacity')->nullable();
//            $table->integer('door_number')->nullable();
//            $table->string('hp_power')->nullable();

//            //Relations
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->uuid('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('categories');

            $table->uuid('model_id')->nullable();
            $table->foreign('model_id')->references('id')->on('categories');

            $table->uuid('combustible_id')->nullable();
            $table->foreign('combustible_id')->references('id')->on('categories');

            $table->uuid('car_body_id')->nullable();
            $table->foreign('car_body_id')->references('id')->on('categories');

            $table->uuid('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('categories');

            $table->uuid('steering_wheel_id')->nullable();
            $table->foreign('steering_wheel_id')->references('id')->on('categories');

            $table->uuid('gearbox_id')->nullable();
            $table->foreign('gearbox_id')->references('id')->on('categories');

            $table->uuid('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('categories');

            $table->uuid('manufacture_year_id')->nullable();
            $table->foreign('manufacture_year_id')->references('id')->on('categories');

            $table->uuid('mileage_km_id')->nullable();
            $table->foreign('mileage_km_id')->references('id')->on('categories');

            $table->uuid('engine_capacity_id')->nullable();
            $table->foreign('engine_capacity_id')->references('id')->on('categories');

            $table->uuid('door_number_id')->nullable();
            $table->foreign('door_number_id')->references('id')->on('categories');

            $table->uuid('hp_power_id')->nullable();
            $table->foreign('hp_power_id')->references('id')->on('categories');

            $table->uuid('owner_id')->nullable(); // de schimbat dupa ce adaugi in cod ownerul anunutlui
            $table->foreign('owner_id')->references('id')->on('owner');
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
        Schema::dropIfExists('announces');
    }
};
