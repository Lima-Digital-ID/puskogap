<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PenugasanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_kegiatan' => 'required',
            'id_jenis_kegiatan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'tamu_vvip' => 'required',
            'biaya' => 'required',
            'jumlah_roda_4' => 'required',
            'jumlah_roda_2' => 'required',
            'poc' => 'required',
            'jumlah_ht' => 'required',
            'penyelenggara' => 'required',
            'jumlah_peserta' => 'required',
            'penanggung_jawab' => 'required',
            'lampiran' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_kegiatan.required' => 'Nama Kegiatan harus diisi.',
            'id_jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi.',
            'waktu_mulai.required' => 'Waktu mulai harus diisi.',
            'waktu_selesai.required' => 'Waktu selesai harus diisi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'tamu_vvip.required' => 'Tamu VVIP harus diisi.',
            'biaya.required' => ' Jumlah Biaya harus diisi.',
            'jumlah_roda_4.required' => 'Jumlah Roda 4 harus diisi.',
            'jumlah_roda_2.required' => 'Jumlah Roda 2 harus diisi.',
            'poc.required' => 'POC harus diisi.',
            'jumlah_ht.required' => 'Jumlah HT harus diisi.',
            'penyelenggara.required' => 'Penyelenggara harus diisi.',
            'jumlah_peserta.required' => 'Jumlah Peserta harus diisi.',
            'penanggung_jawab.required' => 'Penanggung jawab harus diisi.',
            'lampiran.required' => 'Lampiran harus diisi.',
            'status.required' => 'Status harus diisi.',
            'ketarangan.required' => 'Ketarangan harus diisi.',
        ];
    }
}
