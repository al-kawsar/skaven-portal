<?php

namespace App\Http\Requests\Dashboard\Teacher;

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
            'name' => 'required|string|max:100',
            'nip' => 'required|string|size:18|unique:teachers,nip',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'agama' => 'required|string|max:20',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'jurusan' => 'required|string|max:50',
            'no_telepon' => 'required|string|max:25|unique:teachers,no_telepon',
            'tanggal_masuk' => 'required|date',
            'gaji' => 'nullable|integer|min:0',
            'status' => 'required|string',
            'tanggal_pensiun' => 'nullable|date',
            'no_telepon_darurat' => 'nullable|string|max:15',
            'alamat_email_darurat' => 'nullable|email',
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
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.string' => 'NIP harus berupa teks.',
            'nip.size' => 'NIP harus terdiri dari 18 karakter.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 50 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'agama.required' => 'Agama wajib diisi.',
            'agama.string' => 'Agama harus berupa teks.',
            'agama.max' => 'Agama tidak boleh lebih dari 20 karakter.',
            'pendidikan_terakhir.string' => 'Pendidikan terakhir harus berupa teks.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir tidak boleh lebih dari 50 karakter.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'jurusan.string' => 'Jurusan harus berupa teks.',
            'jurusan.max' => 'Jurusan tidak boleh lebih dari 50 karakter.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.string' => 'Nomor telepon harus berupa teks.',
            'no_telepon.max' => 'Nomor telepon tidak boleh lebih dari 25 karakter.',
            'no_telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Tanggal masuk harus berupa tanggal yang valid.',
            'gaji.integer' => 'Gaji harus berupa angka.',
            'gaji.min' => 'Gaji tidak boleh kurang dari 0.',
            'status.required' => 'Status wajib diisi.',
            'status.string' => 'Status harus berupa teks.',
            'tanggal_pensiun.date' => 'Tanggal pensiun harus berupa tanggal yang valid.',
            'no_telepon_darurat.string' => 'Nomor telepon darurat harus berupa teks.',
            'no_telepon_darurat.max' => 'Nomor telepon darurat tidak boleh lebih dari 15 karakter.',
            'alamat_email_darurat.email' => 'Alamat email darurat harus berupa email yang valid.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('tanggal_lahir') || $this->has('tanggal_masuk') || $this->has('tanggal_pensiun')) {
            $this->merge([
                'tanggal_lahir' => date('Y-m-d', strtotime($this->input('tanggal_lahir'))),
                'tanggal_masuk' => date('Y-m-d', strtotime($this->input('tanggal_masuk'))),
                'tanggal_pensiun' => date('Y-m-d', strtotime($this->input('tanggal_masuk'))),
            ]);
        }
    }
}
