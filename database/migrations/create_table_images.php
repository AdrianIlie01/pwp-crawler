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
        Schema::create('images', function (Blueprint $table) {
            // $table->engine = 'InnoDB'; // set the engine to InnoDB => solves error 1824

            $table->uuid('id')->primary();
            $table->string('path');



//            //Relations
            $table->integer('announce_id');
            $table->foreign('announce_id')->references('id')->on('announces');

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
        Schema::dropIfExists('images');
    }
};
