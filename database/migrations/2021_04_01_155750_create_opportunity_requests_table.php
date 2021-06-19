<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunityRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('opportunity_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id');
            $table->foreignId('supplier_id')->nullable();
            $table->float('estimated_budget')->nullable();
            $table->float('current_value')->nullable();
            $table->float('savings')->nullable();
            $table->longText('description')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('status')->default('Pending');
            $table->string('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opportunity_requests');
    }
}
