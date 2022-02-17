<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIdUserOnDetailAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_anggota', function (Blueprint $table) {            
            $table->bigInteger('id_anggota', false, true)->nullable()->after('id');
            $table->foreign('id_anggota')->references('id')->on('anggota')->cascadeOnUpdate()->cascadeOnDelete();

            $table->dropForeign('detail_anggota_id_user_foreign');
            $table->dropColumn('id_user');
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
            $table->bigInteger('id_user', false, true)->nullable()->after('id');
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->dropColumn('id_anggota');
            $table->dropForeign('detail_anggota_id_anggota_foreign');
        }); 
    }
}
