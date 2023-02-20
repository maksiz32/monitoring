<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255);
            $table->string('contracts_master', 255);
            $table->string('speed', 50)->nullable();
            $table->string('price', 30)->nullable();
            $table->string('login_pppoe', 30)->nullable();
            $table->string('password_pppoe', 20)->nullable();
            $table->bigInteger('point_id');
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
        Schema::dropIfExists('contracts');
    }
}
