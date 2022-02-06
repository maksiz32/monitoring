<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('city', 50);
            $table->string('address', 100);
            $table->boolean('is_active')->default(true);
            $table->string('router', 50)->nullable();
            $table->ipAddress('lan_ip')->nullable();
            $table->ipAddress('vpn_ip')->nullable();
            $table->ipAddress('wan_ip')->nullable();
            $table->boolean('telephony_status')->nullable()->default(null);
            $table->string('provider', 250)->nullable();
            $table->string('login', 30)->nullable();
            $table->string('password', 20)->nullable();
            $table->string('ups', 250)->nullable();
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
        Schema::dropIfExists('points');
    }
}
