<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDetailAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_anggota', function (Blueprint $table) {
            $table->bigInteger('id_waktu_penugasan', false, true)->nullable()->after('id_anggota');
            $table->foreign('id_waktu_penugasan')->references('id')->on('waktu_penugasan')->cascadeOnUpdate()->cascadeOnDelete();

            $table->dropForeign('detail_anggota_id_penugasan_foreign');
            $table->dropColumn('id_penugasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_anggota', function (Blueprint $table) {
            $table->bigInteger('id_penugasan', false, true)->nullable()->after('id_anggota');
            $table->foreign('id_penugasan')->references('id')->on('penugasan')->cascadeOnUpdate()->cascadeOnDelete();
        
            $table->dropForeign('detail_anggota_id_waktu_penugasan_foreign');
            $table->dropColumn('id_waktu_penugasan');
        });
    }
}
