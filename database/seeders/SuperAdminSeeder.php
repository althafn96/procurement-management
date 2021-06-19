<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'master-Super Admin',
            'id' => 1,
            'type' => 'master',
            'status' => 0
        ]);
        Role::create([
            'name' => 'client-Admin',
            'id' => 2,
            'type' => 'client',
            'status' => 1,
            'tenant_id' => 'common'
        ]);
        Role::create([
            'name' => 'client-Customer',
            'id' => 3,
            'type' => 'client',
            'status' => 1,
            'tenant_id' => 'common'
        ]);

        DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => 1
        ]);

        DB::table('masters')->insert([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'user_id' => 1
        ]);
    }
}
