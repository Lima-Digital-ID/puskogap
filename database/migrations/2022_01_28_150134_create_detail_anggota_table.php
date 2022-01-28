<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_anggota', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_penugasan', false, true);
            $table->bigInteger('id_user', false, true);
            $table->enum('status', ['Kepala', 'Anggota']);
            $table->timestamps();

            $table->foreign('id_penugasan')->references('id')->on('penugasan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_anggota');
    }
}
