<?php

namespace App\Http\Resources\Class;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Get All Class Data',
            'data' => $this->transformData($this->resource)
        ];
    }

    private function transformData($resources)
    {
        return $resources->map(function ($resource) {
            return [
                'id' => $resource->id,
                'kode' => $resource->kode,
                'nama' => $resource->nama,
                'wali_kelas_id' => $resource->teacher,
                'tingkat_kelas' => $resource->tingkat_kelas,
                'jumlah_siswa' => $resource->jumlah_siswa,
                'tahun_ajaran' => $resource->tahun_ajaran,
            ];
        })->all();
    }

}
