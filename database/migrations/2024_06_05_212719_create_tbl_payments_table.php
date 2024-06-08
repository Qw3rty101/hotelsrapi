<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPaymentsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('tbl_payments', function (Blueprint $table) {
            $table->id('id_payment');
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_payment_method');
            $table->timestamps();

            $table->foreign('id_order')->references('id_order')->on('tbl_orders');
            $table->foreign('id_payment_method')->references('id_payment_method')->on('tbl_payment_methods');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::dropIfExists('tbl_payments');
    }
}
