<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $total = [
            'users' => User::count(),
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'exams' => Exam::count(),
            'subjects' => Subject::count(),
            'class' => Classes::count(),
        ];

        return Inertia::render('App/Dashboard', [
            "total" => $total
        ]);
    }

    public function accountSettings()
    {
        return Inertia::render('App/Setting/General');
    }
    public function accountSecurity()
    {
        return Inertia::render('App/Setting/Security');
    }



}
