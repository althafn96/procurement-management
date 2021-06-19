<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'id' => 1,
            'name' => 'user roles',
            'type' => 'common'
        ]);

        $user_role_permissions = array('view all user roles', 'create user role', 'edit user role', 'remove user role');

        foreach($user_role_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 1
            ]);
        }

        DB::table('modules')->insert([
            'id' => 2,
            'name' => 'staff',
            'type' => 'common'
        ]);

        $user_permissions = array('view all staff', 'create staff', 'edit staff', 'remove staff');

        foreach($user_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 2
            ]);
        }

        DB::table('modules')->insert([
            'id' => 3,
            'name' => 'plans',
            'type' => 'master'
        ]);

        $plan_permissions = array('view all plans', 'create plan', 'edit plan', 'remove plan');

        foreach($plan_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 3
            ]);
        }

        DB::table('modules')->insert([
            'id' => 4,
            'name' => 'clients',
            'type' => 'master'
        ]);

        $client_permissions = array('view all clients', 'create client', 'edit client', 'remove client');

        foreach($client_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 4
            ]);
        }

        DB::table('modules')->insert([
            'id' => 5,
            'name' => 'contacts',
            'type' => 'master'
        ]);

        $contact_permissions = array('view all contacts', 'create contact', 'edit contact', 'remove contact');

        foreach($contact_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 5
            ]);
        }


        DB::table('modules')->insert([
            'id' => 6,
            'name' => 'invoices',
            'type' => 'master'
        ]);

        $invoices_permissions = array('view all invoices');

        foreach($invoices_permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'module_id' => 6
            ]);
        }

    }
}
