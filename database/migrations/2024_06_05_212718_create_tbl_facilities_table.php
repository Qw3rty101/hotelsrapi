<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFacilitiesTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_facilities', function (Blueprint $table) {
            $table->id('id_facility');
            $table->string('name_facility');
            $table->string('icon_facility');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_facilities');
    }
}
