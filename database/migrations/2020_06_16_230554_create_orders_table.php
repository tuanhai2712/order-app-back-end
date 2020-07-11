<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('ten_san_pham')->nullable();
            $table->string('link_san_pham');
            $table->string('ma_van_don')->unique()->nullable();
            $table->string('size')->nullable();
            $table->string('so_luong')->nullable();
            $table->string('mau')->nullable();
            $table->integer('gia_thuc_te')->default(0)->nullable();
            $table->integer('gia_thuc_chi')->default(0)->nullable();
            $table->integer('phi_ship_tq')->default(0)->nullable();
            $table->integer('phi_ship_vn')->default(0)->nullable();
            $table->string('khoi_luong')->default(0)->nullable();
            $table->integer('dat_coc')->default(0)->nullable();
            $table->integer('ty_gia')->default(0)->nullable();
            $table->integer('tinh_trang')->default(0)->nullable();
            $table->longText('note')->default("")->nullable();
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
        Schema::dropIfExists('orders');
    }
}
