<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsHariWaktuPenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waktu_penugasan', function (Blueprint $table) {
            $table->tinyInteger('is_hari')->after('is_tanggal')->comment('1 = Minggu(Sunday)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waktu_penugasan', function (Blueprint $table) {
            //
        });
    }
}
