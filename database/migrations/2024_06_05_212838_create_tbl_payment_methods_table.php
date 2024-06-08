<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_payment_methods', function (Blueprint $table) {
            $table->id('id_payment_method');
            $table->enum('method_payment', ['Dana', 'Qris']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_payment_methods');
    }
}
