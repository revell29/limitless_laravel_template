<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
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
            'nama_pasien' => 'required',
            'umur' => 'required|number',
            'jenis_kelamin' => 'required',
            'no_ktp' => 'required|number',
            'no_hp' => 'required|number',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
        ];
    }
}
