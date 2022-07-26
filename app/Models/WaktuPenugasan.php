<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuPenugasan extends Model
{
    use HasFactory;
    protected $table = 'waktu_penugasan';

    public function detailAnggota()
    {
        return $this->hasMany('\App\Models\DetailAnggota', 'id_waktu_penugasan');
    }

}
