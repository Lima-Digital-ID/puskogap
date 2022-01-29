<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UnitKerjaRequest extends FormRequest
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
            'kode' => 'required|max:30|unique:unit_kerja,kode',
            'unit_kerja' => 'required|max:191',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode harus diisi.',
            'kode.max' => 'Maksimal jumlah karakter 30.',
            'kode.unique' => 'Nama telah digunakan.',
            'unit_kerja.required' => 'Unit kerja harus diisi.',
            'unit_kerja.max' => 'Maksimal jumlah karakter 191.'
        ];
    }
}
