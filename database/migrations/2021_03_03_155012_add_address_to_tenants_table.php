<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToTenantsTable extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('address_flat_no')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_zip')->nullable();
        });
    }


    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn('address_flat_no');
            $table->dropColumn('address_street');
            $table->dropColumn('address_city');
            $table->dropColumn('address_state');
            $table->dropColumn('address_country');
            $table->dropColumn('address_zip');
        });
    }
}
