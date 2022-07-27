<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiKhusus extends Model
{
    use HasFactory;
    protected $table = 'kompetensi_khusus';

    public function detailKompetensiAnggota()
    {
        return $this->hasOne('\App\Models\DetailKompetensiAnggota', 'id_kompetensi');
    }

}
