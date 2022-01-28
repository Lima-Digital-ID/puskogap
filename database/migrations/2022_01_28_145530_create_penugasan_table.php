<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenugasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->tinyInteger('id_jenis_kegiatan', false, true);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->text('lokasi')->nullable();
            $table->string('tamu_vvip')->nullable();
            $table->integer('biaya', false, true)->default(0);
            $table->integer('jumlah_roda_4', false, true)->default(0);
            $table->integer('jumlah_roda_2', false, true)->default(0);
            $table->integer('poc', false, true)->default(0);
            $table->integer('jumlah_ht', false, true)->default(0);
            $table->string('penyelenggara');
            $table->integer('jumlah_peserta', false, true)->default(0);
            $table->text('penanggung_jawab');
            $table->longText('lampiran');
            $table->enum('status', ['Rencana', 'Pelaksanaan', 'Selesai', 'Batal']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_jenis_kegiatan')->references('id')->on('jenis_kegiatan')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penugasan');
    }
}
