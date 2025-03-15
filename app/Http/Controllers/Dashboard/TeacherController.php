<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Teacher\StoreRequest;
use App\Http\Requests\Dashboard\Teacher\UpdateRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index()
    {
        return Inertia::render("App/Teacher/Index");
    }

    public function getData(Request $request)
    {
        try {
            $query = $request->search;
            $field = $request->field;

            if ($query) {
                $cacheKey = 'teachers_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query) {
                    return Teacher::where('name', 'LIKE', "%$query%")
                        ->orWhere('nip', 'LIKE', "%$query%")
                        ->take(20)
                        ->get();
                });

                return response()->json([
                    'status' => "Get Teacher by Search",
                    'data' => $results
                ], 200);
            }

            $totalTeacher = Teacher::count();
            $limit = $request->limit ?? $totalTeacher;

            $type = $request->type ?? 'search';
            if ($type == 'filter') {
                $data = Teacher::query()->limit($limit)->orderBy('name', 'asc')->get(["id", "name"]);
            } else {
                $data = Teacher::query()->limit($limit)->orderBy('name', 'asc')->get();
            }


            return response()->json([
                'status' => "Get All Teachers Data",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        return Inertia::render("App/Teacher/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $email = $payload['nip'] . '@smk7.com';

            if (User::where('email', $email)->exists()) {
                return response()->json([
                    "message" => "Nip ini sudah terdaftar sebagai email."
                ], 422);
            }

            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['nip'] . "@smk7.com",
                'password' => $payload['nip'],
                'role_id' => 2,
            ]);

            $payload['user_id'] = $user->id;
            Teacher::create($payload);

            return response()->json([
                "message" => "Guru berhasil dibuat"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(Teacher $id)
    {
        return Inertia::render("App/Teacher/Edit", [
            "teacher" => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Teacher $id)
    {
        try {
            $payload = $request->validated();
            $email = $payload['nip'] . '@smk7.com';

            $id->updateOrFail($payload);

            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    "email" => $payload['nip'] . '@smk7.com',
                    "password" => $payload['nip']
                ]);
            }
            Cache::flush();

            return response()->json([
                "message" => "Data Guru berhasil diperbarui"
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
    public function destroy(Teacher $id)
    {
        try {
            if ($id->delete() && $id->user->delete()) {
                Cache::flush();

                return response()->json([
                    "message" => 'Guru Berhasil Dihapus'
                ], 200);
            }
            return response()->json([
                "message" => 'Guru Gagal Dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Guru Gagal Dihapus"
            ], 500);
        }
    }
}
