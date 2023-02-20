<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                                        'role' => 'admin',
                                   ]);
        DB::table('users')->insert([
                                       'name' => 'А',
                                       'email' => 'user@admin.ru',
                                       'password' => Hash::make('1'),
                                       'surname' => 'Усманов',
                                       'middle_name' => 'Admin',
                                       'role' => 'user',
                                   ]);
    }
}
