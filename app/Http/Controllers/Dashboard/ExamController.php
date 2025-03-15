<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Exam\StoreRequest;
use App\Http\Requests\Dashboard\Exam\UpdateRequest;
use App\Http\Resources\Exam\ListResource;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function index()
    {
        return Inertia::render("App/Exam/Index", [
            "exams" => Exam::all()
        ]);
    }

    public function getData()
    {
        try {
            $data = Exam::with('student', 'subject')->orderBy("updated_at", "desc")->get();

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
        return Inertia::render("App/Exam/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            Exam::create($payload);

            return response()->json([
                "message" => "Nilai berhasil dibuat"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataById(Request $request, $user_id)
    {
        try {

            $user = User::with('student')->find($user_id);

            $data = Exam::with('student', 'subject')->where('student_id', $user->student->id)->get();

            $res = new ListResource($data);

            return response()->json($res, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function show(Exam $id)
    {
        return Inertia::render("App/Exam/Detail", [
            "exam" => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $id)
    {
        return Inertia::render("App/Exam/Edit", [
            "exam" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Exam $id)
    {
        try {
            $payload = $request->validated();

            $id->updateOrFail($payload);

            return response()->json([
                "message" => "Data Nilai berhasil diperbarui"
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
    public function destroy(Exam $id)
    {
        try {
            if ($id->delete()) {
                return response()->json([
                    "message" => 'Nilai Berhasil Dihapus'
                ], 200);
            }
            return response()->json([
                "message" => 'Nilai Gagal Dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Nilai Gagal Dihapus"
            ], 500);
        }
    }
}
