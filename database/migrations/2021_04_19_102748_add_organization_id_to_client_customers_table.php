<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdToClientCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('client_customers', function (Blueprint $table) {
            $table->foreignId('customer_organization_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('client_customers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_organization_id');
        });
    }
}
