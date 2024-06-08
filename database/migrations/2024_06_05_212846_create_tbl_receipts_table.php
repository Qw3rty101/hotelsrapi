<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_receipts', function (Blueprint $table) {
            $table->id('id_receipt');
            $table->unsignedBigInteger('id_payment');
            $table->timestamps();

            $table->foreign('id_payment')->references('id_payment')->on('tbl_payments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_receipts');
    }
}
