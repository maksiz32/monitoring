<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointHasPrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_has_printers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('point_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('printer_id')
                ->constrained()
                ->onDelete('cascade');
            $table->boolean('is_spare')->default(false);
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
        Schema::dropIfExists('point_has_printers');
    }
}
