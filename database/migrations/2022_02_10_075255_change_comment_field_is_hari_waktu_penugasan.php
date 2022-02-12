<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCommentFieldIsHariWaktuPenugasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waktu_penugasan', function (Blueprint $table) {
            $table->dropColumn('is_hari');
            // $table->tinyInteger('is_hari')->comment('1 = Minggu(Sunday)');
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
            //
        });
    }
}
