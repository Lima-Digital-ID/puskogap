<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{

    public function golongan()
    {
        return $this->belongsTo('\App\Models\Golongan', 'id_golongan')->withDefault(['pangkat' => '-']);
    }

    public function jabatan()
    {
        return $this->belongsTo('\App\Models\Jabatan', 'id_jabatan')->withDefault(['jabatan' => '-']);
    }

    public function unit_kerja()
    {
        return $this->belongsTo('\App\Models\UnitKerja', 'id_unit_kerja')->withDefault(['unit_kerja' => '-']);
    }

    public function kompetensi_khusus()
    {
        return $this->belongsTo('\App\Models\KompetensiKhusus', 'id_kompetensi_khusus')->withDefault(['kompetensi_khusus' => '-']);
    }
    public function detailKompetensiAnggota()
    {
        return $this->hasMany('\App\Models\DetailKompetensiAnggota', 'id_anggota');
    }

    public function detailAnggota()
    {
        return $this->hasOne('\App\Models\DetailAnggota', 'id_anggota');
    }


    use HasFactory;
    protected $table = 'anggota';
}
