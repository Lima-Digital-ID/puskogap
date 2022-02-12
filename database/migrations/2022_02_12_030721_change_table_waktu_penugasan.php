<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableWaktuPenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waktu_penugasan', function (Blueprint $table) {
            $table->dropColumn('is_tanggal');
            $table->dropColumn('is_hari');
            $table->date("tanggal")->after('id_penugasan');
            $table->time("is_dari")->change();
            $table->time("is_sampai")->change();
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
            $table->tinyInteger('is_tanggal');
            $table->tinyInteger('is_hari');
            $table->dropColumn("tanggal");
            $table->date("is_dari")->change();
            $table->date("is_sampai")->change();
        });
    }
}
