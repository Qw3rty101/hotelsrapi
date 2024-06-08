<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('id_room');
            $table->unsignedBigInteger('id_facility');
            $table->integer('price_order');
            $table->date('check_in');
            $table->date('check_out');
            $table->time('order_time');
            $table->enum('status_order', ['Booking', 'Live', 'Expired']);
            $table->timestamp('order_at')->useCurrent();
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users');
            $table->foreign('id_room')->references('id_room')->on('tbl_rooms');
            $table->foreign('id_facility')->references('id_facility')->on('tbl_facilities');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_orders');
    }
}
