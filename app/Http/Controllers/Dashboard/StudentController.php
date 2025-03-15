<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Student\StoreRequest;
use App\Http\Requests\Dashboard\Student\UpdateRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("App/Student/Index");
    }
    public function getData(Request $request)
    {
        try {
            $query = $request->input('search');
            $limit = $request->input('limit', Student::count()); // Default to total count if not provided
            $type = $request->input('type', 'search'); // Default to 'search' if not provided

            $query = $request->input('search');
            if ($query) {
                $cacheKey = 'students_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $type) {
                    return Student::where('name', 'LIKE', "%$query%")
                    ->orWhere('nisn', 'LIKE', "%$query%")
                    ->orWhere('nis', 'LIKE', "%$query%")
                    ->orderBy('nisn', 'desc')
                    ->take(20)
                    ->get();
                });

                return response()->json([
                    'status' => "Get Student by Search",
                    'data' => $results
                ], 200);
            }

            if ($type === "search")
                $data = Student::query()->orderBy('name', 'desc')->limit($limit)->get();
            if ($type === "filter")
                $data = Student::limit($limit)->get(['id', 'name']);


            return response()->json([
                'status' => "Get All Students Data",
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



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $email = $payload['nisn'] . '@smk7.com';

            if (User::where('email', $email)->exists()) {
                return response()->json([
                    "message" => "NISN ini sudah terdaftar sebagai email."
                ], 422);
            }

            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['nisn'] . "@smk7.com",
                'password' => $payload['nisn'],
                'role_id' => 3,
            ]);

            $payload['user_id'] = $user->id;
            Student::create($payload);

            return response()->json([
                "message" => "Siswa berhasil dibuat"
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
    public function show(Student $id)
    {
        return Inertia::render("App/Student/Detail", [
            "student" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Student $id)
    {
        try {
            $payload = $request->validated();
            $email = $payload['nisn'] . '@smk7.com';

            $id->updateOrFail($payload);

            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    "email" => $payload['nisn'] . '@smk7.com',
                    "password" => $payload['nisn']
                ]);
            }

            Cache::flush();
            return response()->json([
                "message" => "Data Siswa berhasil diperbarui"
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
    public function destroy(Student $id)
    {
        try {
            if ($id->delete() && $id->user->delete()) {
                Cache::flush();
                return response()->json([
                    "message" => 'Siswa Berhasil Dihapus'
                ], 200);
            }
            return response()->json([
                "message" => 'Siswa Gagal Dihapus'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Siswa Gagal Dihapus"
            ], 500);
        }
    }
}
