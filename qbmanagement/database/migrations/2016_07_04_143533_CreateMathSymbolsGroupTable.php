<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMathSymbolsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /** Schema::create('math_symbols_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group_name');
            $table->timestamps();
            $table->string('div_id',45);
        }); **/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('math_symbols_group');
    }
}
