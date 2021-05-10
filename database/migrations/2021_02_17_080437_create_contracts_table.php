<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_number');
            $table->string('station');
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('advertiser_id');
            $table->string('product');
            $table->string('bo_type');
            $table->string('parent_bo');
            $table->string('bo_number');
            $table->string('ce_number');
            $table->date('bo_date');
            $table->date('commencement');
            $table->date('end_of_broadcast');
            $table->string('detail', 1000);
            $table->string('package_cost');
            $table->string('package_cost_vat');
            $table->integer('package_cost_salesdc');
            $table->decimal('manila_cash', 50, 2);
            $table->decimal('cebu_cash', 50, 2);
            $table->decimal('davao_cash', 50, 2);
            $table->decimal('total_cash', 50, 2);
            $table->decimal('manila_ex', 50, 2);
            $table->decimal('cebu_ex', 50, 2);
            $table->decimal('davao_ex', 50, 2);
            $table->decimal('total_ex', 50, 2);
            $table->decimal('total_amount', 50, 2);
            $table->string('prod_cost');
            $table->string('prod_cost_vat');
            $table->string('prod_cost_salesdc');
            $table->decimal('manila_prod', 50, 2);
            $table->decimal('cebu_prod', 50, 2);
            $table->decimal('davao_prod', 50, 2);
            $table->decimal('total_prod', 50, 2);
            $table->unsignedBigInteger('ae');
            $table->tinyInteger('is_printed')->nullable(0);
            $table->tinyInteger('is_active')->nullable(1);
            $table->timestamps();

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
        Schema::dropIfExists('contracts');
    }
}
