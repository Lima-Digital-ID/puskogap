<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
    
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_pegawai',
        'jenis_kelamin',
        'nip',
        'level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
