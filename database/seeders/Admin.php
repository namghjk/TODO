<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Super',
            'email' => 'superadmin@khgc.com',
            'password' => bcrypt('Abcd@1234'),
            'role' => 'admin',
            'status' => 1,
        ]);
    }
}
