<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTypologies extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('typologies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('identifier')->unique();
            $table->string('icon')->nullable();
            // $table->string('had_pagebuilder');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('typologies');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
