<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldAnggotaOnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->bigInteger('id_anggota', false, true)->nullable()->after('email_verified_at');
            $table->foreign('id_anggota')->references('id')->on('anggota')->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->dropForeign('users_id_golongan_foreign');
            $table->dropColumn('id_golongan');

            $table->dropForeign('users_id_jabatan_foreign');
            $table->dropColumn('id_jabatan');
            
            $table->dropForeign('users_id_unit_kerja_foreign');
            $table->dropColumn('id_unit_kerja');

            $table->dropForeign('users_id_kompetensi_khusus_foreign');
            $table->dropColumn('id_kompetensi_khusus');
            
            $table->dropColumn('jenis_pegawai');
            $table->dropColumn('jenis_kelamin');
            $table->dropColumn('nip');

            $table->dropColumn('nama');
            $table->dropColumn('phone');
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
            $table->string('phone',15)->after('password');

            $table->tinyInteger('id_golongan', false, true)->nullable()->after('phone');
            $table->tinyInteger('id_jabatan', false, true)->nullable()->after('id_golongan');
            $table->tinyInteger('id_unit_kerja', false, true)->nullable()->after('id_jabatan');
            $table->tinyInteger('id_kompetensi_khusus', false, true)->nullable()->after('id_unit_kerja');

            $table->foreign('id_golongan')->references('id')->on('golongan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_jabatan')->references('id')->on('jabatan')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_unit_kerja')->references('id')->on('unit_kerja')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('id_kompetensi_khusus')->references('id')->on('kompetensi_khusus')->cascadeOnUpdate()->cascadeOnDelete();

            $table->enum('jenis_pegawai',['ASN', 'PTT-PK']);
            $table->enum('jenis_kelamin',['L', 'P']);
            $table->string('nip',30);
        });
    }
}
