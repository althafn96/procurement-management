<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedUserPipelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_staff_pipeline', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_staff_id')->contsrained('users')->onUpdate('cascade')->ondelete('cascade');
            $table->foreignId('pipeline_id')->contsrained('pipelines')->onUpdate('cascade')->ondelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_staff_pipeline');
    }
}
