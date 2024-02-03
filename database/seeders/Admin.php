<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        // Tạo role 'admin' nếu nó chưa tồn tại
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Tạo người dùng admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Super',
            'email' => 'superadmin@khgc.com',
            'password' => bcrypt('Abcd@1234'),
            'role'=>'admin',
            'status' => 1,
        ]);

        // Gán role 'admin' cho người dùng admin
        $admin->assignRole($adminRole);

    }
}
