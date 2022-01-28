<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('id_golongan', false, true)->nullable()->after('password');
            $table->tinyInteger('id_jabatan', false, true)->nullable()->after('id_golongan');
            $table->tinyInteger('id_unit_kerja', false, true)->nullable()->after('id_jabatan');
            $table->tinyInteger('id_kompetensi_khusus', false, true)->nullable()->after('id_unit_kerja');

            $table->foreign('id_golongan')->references('id')->on('golongan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_jabatan')->references('id')->on('jabatan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_unit_kerja')->references('id')->on('unit_kerja')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_kompetensi_khusus')->references('id')->on('kompetensi_khusus')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            
        });
    }
}
