<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KompetensiKhususRequest extends FormRequest
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
            'kode' => 'required',
            'kompetensi_khusus' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode harus diisi.',
            'kompetensi_khusus.required' => 'Kompetensi Khusus harus diisi.',
        ];
    }
}
