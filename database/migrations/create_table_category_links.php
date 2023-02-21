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
        Schema::create('category_links', function (Blueprint $table) {
            // $table->engine = 'InnoDB'; // set the engine to InnoDB => solves error 1824

            $table->uuid('id')->primary();

//            //Relations
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->uuid('parent_id');
            $table->foreign('parent_id')->references('id')->on('categories');

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
        Schema::dropIfExists('category_links');
    }
};
