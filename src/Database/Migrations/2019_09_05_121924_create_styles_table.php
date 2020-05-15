<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->unique();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('styles_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('style_id')->unsigned();
            $table->foreign('style_id')->references('id')->on('styles')->onDelete('cascade');
            $table->integer('language_id')->unsigned()->nullable();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->string('name');
            $table->longText('value')->nullable();
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
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('styles_fields');
        Schema::dropIfExists('styles');
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
