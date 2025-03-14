<?php

namespace App\Http\Resources\Subject;

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
            'message' => 'Get All Subject Data',
            'data' => $this->transformData($this->resource)
        ];
    }

    private function transformData($resources)
    {
        return $resources->map(function ($resource) {
            return [
                'id' => $resource->id,
                'kode' => $resource->kode,
                'guru_id' => $resource->teacher,
                'nama' => $resource->nama,
                'deskripsi' => $resource->deskripsi,
                'jenis_pelajaran' => $resource->jenis_pelajaran,
            ];
        })->all();
    }
}
