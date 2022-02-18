<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penugasan', function (Blueprint $table) {
            $table->dropColumn('biaya');
            $table->dropColumn('jumlah_roda_4');
            $table->dropColumn('jumlah_roda_2');
            $table->dropColumn('poc');
            $table->dropColumn('jumlah_ht');
            $table->dropColumn('jumlah_peserta');
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
            $table->integer('biaya', false, true)->default(0);
            $table->integer('jumlah_roda_4', false, true)->default(0);
            $table->integer('jumlah_roda_2', false, true)->default(0);
            $table->integer('poc', false, true)->default(0);
            $table->integer('jumlah_ht', false, true)->default(0);
            $table->integer('jumlah_peserta', false, true)->default(0);
        });
    }
}
