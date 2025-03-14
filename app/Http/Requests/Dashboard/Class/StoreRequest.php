<?php

namespace App\Http\Requests\Dashboard\Class;

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

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:50',
            'wali_kelas_id' => 'required|exists:teachers,id',
            'tahun_ajaran' => 'required|string|regex:/^\d{4}\/\d{4}$/',
            'tingkat_kelas' => 'required|integer|min:1|max:3',
            'jumlah_siswa' => 'integer|min:0'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kelas wajib diisi.',
            'nama.string' => 'Nama kelas harus berupa string.',
            'nama.max' => 'Nama kelas tidak boleh lebih dari 50 karakter.',
            'wali_kelas_id.required' => 'Wali kelas wajib dipilih.',
            'wali_kelas_id.exists' => 'Wali kelas yang dipilih tidak valid.',
            'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
            'tahun_ajaran.string' => 'Tahun ajaran harus berupa string.',
            'tahun_ajaran.regex' => 'Format tahun ajaran tidak valid. Contoh: "2023/2024".',
            'tingkat_kelas.required' => 'Tingkat kelas wajib diisi.',
            'tingkat_kelas.integer' => 'Tingkat kelas harus berupa angka.',
            'tingkat_kelas.min' => 'Tingkat kelas tidak boleh kurang dari 1.',
            'tingkat_kelas.max' => 'Tingkat kelas tidak boleh lebih dari 3.',
            'jumlah_siswa.integer' => 'Jumlah siswa harus berupa angka.',
            'jumlah_siswa.min' => 'Jumlah siswa tidak boleh kurang dari 0.'
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('wali_kelas_id') && is_array($this->input('wali_kelas_id'))) {
            $this->merge([
                'wali_kelas_id' => $this->input('wali_kelas_id')['id']
            ]);
        }
    }
}
