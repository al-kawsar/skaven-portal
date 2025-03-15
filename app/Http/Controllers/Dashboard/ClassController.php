<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\CodeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Class\StoreRequest;
use App\Http\Requests\Dashboard\Class\UpdateRequest;
use App\Http\Resources\Class\ListResource;
use App\Models\Classes;
use Inertia\Inertia;

class ClassController extends Controller
{
    public function index()
    {
        return Inertia::render("App/Class/Index");
    }


    public function getData()
    {
        try {

            $data = Classes::with('teacher')->orderBy("updated_at", "desc")->get();

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
        return Inertia::render("App/Class/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $payload['kode'] = (new CodeHelper)->generate_random_code();

            Classes::create($payload);

            return response()->json([
                "message" => "Kelas berhasil dibuat"
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
    public function show(Classes $id)
    {
        return Inertia::render("App/Class/Detail", [
            "class" => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $id)
    {
        return Inertia::render("App/Class/Edit", [
            "class" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Classes $id)
    {
        try {
            $payload = $request->validated();

            $id->updateOrFail($payload);

            return response()->json([
                "message" => "Data Kelas berhasil diperbarui"
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
    public function destroy(Classes $id)
    {
        try {
            if ($id->delete()) {
                return response()->json([
                    "message" => 'Kelas Berhasil Dihapus'
                ], 200);
            }
            return response()->json([
                "message" => 'Kelas Gagal Dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Kelas Gagal Dihapus"
            ], 500);
        }
    }
}
