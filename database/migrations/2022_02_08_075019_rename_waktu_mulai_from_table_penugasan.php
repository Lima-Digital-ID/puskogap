<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameWaktuMulaiFromTablePenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penugasan', function (Blueprint $table) {
            $table->time('waktu_mulai')->change();
            $table->time('waktu_selesai')->change();
            $table->enum('model_penugasan',['1','2','3'])->comment('1 Khsusus, 2 Mingguan, 3 Bulanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penugasan', function (Blueprint $table) {
            $table->dateTime('waktu_mulai')->change();
            $table->dateTime('waktu_selesai')->change();
            $table->dropColumn('model_penugasan');
        });
    }
}
