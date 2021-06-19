<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTenantIdToRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
        });
    }


    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('tenant_id');
        });
    }
}
