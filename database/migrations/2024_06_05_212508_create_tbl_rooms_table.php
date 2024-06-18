<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_rooms', function (Blueprint $table) {
            $table->id('id_room');
            $table->string('name_room');
            $table->integer('price');
            $table->integer('qty');
            $table->text('rating');
            $table->string('short_desc');
            $table->text('detail_desc');
            $table->string('img_path');
            $table->enum('category_room', ['private', 'date', 'meeting']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_rooms');
    }
}
