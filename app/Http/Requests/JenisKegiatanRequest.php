<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JenisKegiatanRequest extends FormRequest
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
            'kode' => 'required|max:30|unique:jenis_kegiatan,kode',
            'jenis_kegiatan' => 'required|max:191',
            'jenis' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Maksimal jumlah karakter 30.',
            'kode.unique' => 'Kode telah digunakan.',
            'jenis_kegiatan.required' => 'Jenis Kegiatan harus diisi.',
            'jenis_kegiatan.max' => 'Maksimal jumlah karakter 191.',
            'jenis.required' => 'Jenis harus diisi.',
        ];
    }
}
