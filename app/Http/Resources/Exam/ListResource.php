<?php

namespace App\Http\Resources\Exam;

use Carbon\Carbon;
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
            'message' => 'Get All Exam Data',
            'data' => $this->transformData($this->resource)
        ];
    }

    private function transformData($resources)
    {
        return $resources->map(function ($resource) {
            return [
                'id' => $resource->id,
                'nilai' => $resource->nilai,
                'tanggal_nilai' => Carbon::parse($resource->tanggal_nilai)->format('j F Y'),
                'student_id' => [
                    'id' => $resource->student->id,
                    'name' => $resource->student->name,
                ],
                'subject_id' => [
                    'id' => $resource->subject->id,
                    'nama' => $resource->subject->nama,
                ],
            ];
        })->all();
    }


}
