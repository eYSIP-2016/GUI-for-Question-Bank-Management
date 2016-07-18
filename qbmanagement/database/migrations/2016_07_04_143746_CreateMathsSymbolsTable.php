<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMathsSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**Schema::create('maths_symbols', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('description')->unique();
            $table->integer('type');
            $table->timestamps();
        });**/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('maths_symbols');
    }
}
