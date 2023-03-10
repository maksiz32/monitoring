<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointHasDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_has_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('device_id')
                ->constrained()
                ->onDelete('cascade');
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('point_has_devices');
    }
}
