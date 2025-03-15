<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\CodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Subject\StoreRequest;
use App\Http\Requests\Dashboard\Subject\UpdateRequest;
use App\Http\Resources\Subject\ListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        return Inertia::render("App/Subject/Index");
    }
    public function getData(Request $request)
    {
        try {
            $query = $request->input('search');
            $limit = $request->input('limit', Subject::count()); // Default to total count if not provided
            $type = $request->input('type', 'search'); // Default to 'search' if not provided

            if ($query) {
                $cacheKey = 'subjects_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $limit) {
                    return Subject::where('nama', 'LIKE', "%$query%")
                        ->orWhere('slug', 'LIKE', "%$query%")
                        ->take($limit)
                        ->get();
                });

                return response()->json([
                    'status' => "Get Subject by Search",
                    'data' => $results
                ], 200);
            }
            $totalSubject = Subject::count();
            $limit = $request->limit ?? $totalSubject;

            if ($type === "search")
                $data = Subject::query()->limit($limit)->get();
            if ($type === "filter")
                $data = Subject::limit($limit)->get(['id', 'nama']);

            $res = new ListResource($data);

            return response()->json($res, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("App/Subject/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $payload['kode'] = (new CodeHelper)->generate_random_code();

            Subject::create($payload);

            return response()->json([
                "message" => "Mata Pelajaran berhasil dibuat"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $id)
    {
        return Inertia::render("App/Subject/Detail", [
            "subject" => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $id)
    {
        return Inertia::render("App/Subject/Edit", [
            "subject" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Subject $id)
    {
        try {
            $payload = $request->validated();

            $id->updateOrFail($payload);

            return response()->json([
                "message" => "Data Mata Pelajaran berhasil diperbarui"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $id)
    {
        try {
            if ($id->delete()) {
                return response()->json([
                    "message" => 'Mata Pelajaran Berhasil Dihapus'
                ], 200);
            }
            return response()->json([
                "message" => 'Mata Pelajaran Gagal Dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Mata Pelajaran Gagal Dihapus"
            ], 500);
        }
    }
}
