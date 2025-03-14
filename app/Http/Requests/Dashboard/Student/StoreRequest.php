<?php

namespace App\Http\Requests\Dashboard\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'nis' => 'required|string|max:6|unique:students,nis',
            'nisn' => 'required|string|max:12|unique:students,nisn|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:50',
            'agama' => 'required|string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama siswa wajib diisi.',
            'name.string' => 'Nama siswa harus berupa teks.',
            'name.max' => 'Nama siswa tidak boleh lebih dari 50 karakter.',

            'nis.required' => 'NIS wajib diisi.',
            'nis.string' => 'NIS harus berupa teks.',
            'nis.max' => 'NIS harus tepat 6 karakter.',
            'nis.unique' => 'NIS ini sudah terdaftar.',

            'nisn.required' => 'NISN wajib diisi.',
            'nisn.string' => 'NISN harus berupa teks.',
            'nisn.max' => 'NISN harus tepat 12 karakter.',
            'nisn.unique' => 'NISN ini sudah terdaftar.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus diisi dengan L (Laki-laki) atau P (Perempuan).',

            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 100 karakter.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 50 karakter.',

            'agama.required' => 'Agama wajib diisi.',
            'agama.string' => 'Agama harus berupa teks.',
            'agama.max' => 'Agama tidak boleh lebih dari 10 karakter.',
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->has('tanggal_lahir')) {
            $this->merge([
                'tanggal_lahir' => date('Y-m-d', strtotime($this->input('tanggal_lahir'))),
            ]);
        }
    }
}
