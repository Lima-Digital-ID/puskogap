<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis_pegawai', ['ASN', 'PTT-PK']);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nip', 30);
            $table->tinyInteger('id_golongan')->nullable();
            $table->tinyInteger('id_jabatan')->nullable();
            $table->tinyInteger('id_unit_kerja')->nullable();
            $table->tinyInteger('id_kompetensi_khusus')->nullable();
            // $table->foreign('id_golongan')->references('id')->on('golongan')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('id_jabatan')->references('id')->on('jabatan')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('id_unit_kerja')->references('id')->on('unit_kerja')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreign('id_kompetensi_khusus')->references('id')->on('kompetensi_khusus')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota');
    }
}
