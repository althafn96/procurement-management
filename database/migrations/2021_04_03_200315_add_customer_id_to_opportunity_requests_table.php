<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToOpportunityRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('opportunity_requests', function (Blueprint $table) {
            $table->foreignId('client_customer_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('opportunity_requests', function (Blueprint $table) {
            $table->dropColumn('client_customer_id');
        });
    }
}
