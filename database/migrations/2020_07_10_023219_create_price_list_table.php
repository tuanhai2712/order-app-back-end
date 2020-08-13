<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list', function (Blueprint $table) {
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->increments('id')->nullable(false)->unsigned();
            $table->integer('freight_charges_ls_fast_20')->nullable();
            $table->integer('freight_charges_ls_slow_20')->nullable();
            $table->integer('freight_charges_ls_fast_20_100')->nullable();
            $table->integer('freight_charges_ls_slow_20_100')->nullable();
            $table->integer('freight_charges_ls_fast_100')->nullable();
            $table->integer('freight_charges_ls_slow_100')->nullable();
            $table->integer('freight_charges_hn_fast_100')->nullable();
            $table->integer('freight_charges_hn_slow_100')->nullable();
            $table->integer('freight_charges_hcm_fast_100')->nullable();
            $table->integer('freight_charges_hcm_slow_100')->nullable();
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
        Schema::dropIfExists('price_list');
    }
}
