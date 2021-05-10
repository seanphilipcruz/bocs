<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id');
            $table->string('bo_number');
            $table->string('bo_type');
            $table->string('station');
            $table->string('month');
            $table->string('year');
            $table->string('type');
            $table->string('amount_type');
            $table->decimal('amount', 50);
            $table->decimal('gross_amount', 50);
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('advertiser_id');
            $table->unsignedBigInteger('ae');
            $table->string('invoice_no')->nullable('none');
            $table->timestamps();

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts')
                ->onDelete('cascade');

            $table->foreign('ae')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');

            $table->foreign('agency_id')
                ->references('agency_code')
                ->on('agencies')
                ->onDelete('cascade');

            $table->foreign('advertiser_id')
                ->references('advertiser_code')
                ->on('advertisers')
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
        Schema::dropIfExists('sales');
    }
}
