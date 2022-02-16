<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;
    protected $table = 'penugasan';

    public function jenis_kegiatan()
    {
        return $this->belongsTo('\App\Models\JenisKegiatan', 'id_jenis_kegiatan')->withDefault(['jenis_kegiatan' => '-']);
    }
    
}
