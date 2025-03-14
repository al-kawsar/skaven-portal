<?php

namespace App\Http\Requests\Dashboard\Exam;

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
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_nilai' => 'required|date',
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
            'student_id.required' => 'Siswa harus dipilih.',
            'student_id.exists' => 'Siswa yang dipilih tidak valid.',
            'subject_id.required' => 'Mata pelajaran harus dipilih.',
            'subject_id.exists' => 'Mata pelajaran yang dipilih tidak valid.',
            'nilai.required' => 'Nilai harus diisi.',
            'nilai.numeric' => 'Nilai harus berupa angka.',
            'nilai.min' => 'Nilai tidak boleh kurang dari 0.',
            'nilai.max' => 'Nilai tidak boleh lebih dari 100.',
            'tanggal_nilai.required' => 'Tanggal nilai harus diisi.',
            'tanggal_nilai.date' => 'Tanggal nilai harus berupa tanggal yang valid.',
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'tanggal_nilai' => date('Y-m-d', strtotime($this->input('tanggal_nilai'))),
            'subject_id' => $this->input('subject_id')['id'],
            'student_id' => $this->input('student_id')['id']
        ]);
    }
}
