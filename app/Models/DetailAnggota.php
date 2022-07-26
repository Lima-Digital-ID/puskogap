<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAnggota extends Model
{
    use HasFactory;
    protected $table = 'detail_anggota';

    public function waktuPenugasan()
    {
        return $this->belongsTo('\App\Models\WaktuPenugasan', 'id_waktu_penugasan');
    }

    public function anggota()
    {
        return $this->belongsTo('\App\Models\Anggota', 'id_anggota');
    }



}
