<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKompetensiAnggota extends Model
{
    use HasFactory;

    public function anggota()
    {
        return $this->belongsTo('\App\Models\Anggota', 'id_anggota');
    }
    public function kompetensi()
    {
        return $this->belongsTo('\App\Models\KompetensiKhusus', 'id_kompetensi');
    }

}
