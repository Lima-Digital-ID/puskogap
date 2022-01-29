<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JabatanRequest extends FormRequest
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
            'jabatan' => 'required|max:191'
        ];
    }

    public function messages()
    {
        return [
            'jabatan.required' => 'Jabatan harus diisi.',
            'jabatan.max' => 'Maksimal jumlah karakter 191.'
        ];
    }
}
