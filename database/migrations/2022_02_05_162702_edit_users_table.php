<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->after('name')->comment('Фамилия');
            $table->string('middle_name')->after('surname')->nullable()->comment('Отчество');
            $table->string('position')->nullable()->comment('Должность');
            $table->string('role', 20)->default('user');
            $table->boolean('active')->default(true);
            $table->string('comment')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('work_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('surname');
            $table->dropColumn('middle_name');
            $table->dropColumn('position');
            $table->dropColumn('active');
            $table->dropColumn('comment');
            $table->dropColumn('mobile_phone');
            $table->dropColumn('work_phone');
        });
    }
}
