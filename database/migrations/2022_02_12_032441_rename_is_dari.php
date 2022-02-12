<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIsDari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waktu_penugasan', function (Blueprint $table) {
            $table->renameColumn('is_dari','waktu_mulai');
            $table->renameColumn('is_sampai','waktu_selesai');
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
            $table->renameColumn('waktu_mulai','is_dari');
            $table->renameColumn('waktu_selesai','is_sampai');
            //
        });
    }
}
