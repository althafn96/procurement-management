<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{

    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'Basic',
            'admins_count' => 2,
            'price' => 15
        ]);

        DB::table('plans')->insert([
            'name' => 'Standard',
            'admins_count' => 5,
            'price' => 35
        ]);

        DB::table('plans')->insert([
            'name' => 'Premium',
            'admins_count' => 10,
            'price' => 55
        ]);
    }
}
