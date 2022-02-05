<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                                       'name' => 'Андрей',
                                       'email' => 'admin@admin.ru',
                                       'password' => Hash::make('Q5NhgA'),
                                       'surname' => 'Усманов',
                                       'middle_name' => 'Admin',
                                   ]);
    }
}
