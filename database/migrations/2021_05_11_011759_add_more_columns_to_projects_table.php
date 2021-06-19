<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('reference_no')->nullable();
            $table->string('cpv_code')->nullable();
            $table->string('sme_friendly')->nullable();
            $table->string('social_value_act')->nullable();
            $table->string('finance_advisor')->nullable();
            $table->string('legal_advisor')->nullable();
            $table->string('other_advisors')->nullable();
            $table->string('project_priority')->nullable();
            $table->string('rag_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
}
