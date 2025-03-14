<?php

namespace App\Http\Requests\Dashboard\Subject;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'nama' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:subjects,slug,' . $this->id,
            'deskripsi' => 'nullable|string',
            'jenis_pelajaran' => 'required|in:Umum,Produktif',
            'guru_id' => 'required|exists:teachers,id',
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
            'nama.required' => 'Nama mata pelajaran harus diisi.',
            'nama.string' => 'Nama mata pelajaran harus berupa teks.',
            'nama.max' => 'Nama mata pelajaran tidak boleh lebih dari 100 karakter.',
            'slug.required' => 'Slug mata pelajaran harus diisi.',
            'slug.string' => 'Slug mata pelajaran harus berupa teks.',
            'slug.max' => 'Slug mata pelajaran tidak boleh lebih dari 100 karakter.',
            'slug.unique' => 'Slug mata pelajaran sudah digunakan.',
            'deskripsi.string' => 'Deskripsi mata pelajaran harus berupa teks.',
            'jenis_pelajaran.required' => 'Jenis mata pelajaran harus dipilih.',
            'jenis_pelajaran.in' => 'Jenis mata pelajaran tidak valid.',
            'guru_id.required' => 'Guru pengajar harus dipilih.',
            'guru_id.exists' => 'Guru pengajar yang dipilih tidak valid.',
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => str()->slug($this->input('slug', $this->input('nama'))) . '-' . str()->random(6),
        ]);
        if ($this->has('guru_id') && is_array($this->input('guru_id'))) {
            $this->merge([
                'guru_id' => $this->input('guru_id')['id']
            ]);
        }
    }
}
