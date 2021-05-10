<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyAdvertiserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_advertiser_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advertiser_id')->nullable();
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->string('action');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('advertiser_id')
                ->references('advertiser_code')
                ->on('advertisers')
                ->onDelete('cascade');

            $table->foreign('agency_id')
                ->references('agency_code')
                ->on('agencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('agency_advertiser_logs');
    }
}
