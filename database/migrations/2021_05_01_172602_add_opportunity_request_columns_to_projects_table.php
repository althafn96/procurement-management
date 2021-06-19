<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpportunityRequestColumnsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title');
            $table->foreignId('category_id');
            $table->foreignId('supplier_id')->nullable();
            $table->longText('description')->nullable();
            $table->float('estimated_budget')->nullable();
            $table->float('allocate')->nullable();
            $table->float('current_value')->nullable();
            $table->float('savings')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
