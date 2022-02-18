<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnggotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:191',
            'jenis_pegawai' => 'required',
            'jenis_kelamin' => 'required',
            'nip' => 'required|max:30',
            'id_golongan' => 'required',
            'id_jabatan' => 'required',
            'id_unit_kerja' => 'required',
            'id_kompetensi_khusus' => 'required',
            'phone' => 'required|max:13',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Maksimal jumlah karakter 100.',
            'jenis_pegawai.required' => 'Jenis Pegawai harus diisi.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus diisi.',
            'nip.required' => 'NIP harus diisi.',
            'nip.max' => 'Maksimal jumlah karakter 30.',
            'id_golongan.required' => 'Golongan harus diisi.',
            'id_jabatan.required' => 'Jabatan harus diisi.',
            'id_unit_kerja.required' => 'Unit Kerja harus diisi.',
            'id_kompetensi_khusus.required' => 'Kompetensi Khusus harus diisi.',
            'phone.required' => 'Nomor Handphone harus diisi.',
            'phone.max' => 'Maksimal jumlah angka 13.',
        ];
    }
}
