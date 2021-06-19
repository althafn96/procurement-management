<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtColumnToClientCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('client_customers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('client_customers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
