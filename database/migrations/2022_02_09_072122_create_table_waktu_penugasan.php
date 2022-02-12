<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWaktuPenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waktu_penugasan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_penugasan')->unsigned();
            $table->tinyInteger('is_hari')->comment('1 = Senin');
            $table->tinyInteger('is_tanggal');
            $table->date('is_dari');
            $table->date('is_sampai');
            $table->timestamps();

            // $table->foreign('id_penugasan')->references('id')->on('penugasan')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waktu_penugasan');
    }
}
