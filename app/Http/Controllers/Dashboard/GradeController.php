<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class GradeController extends Controller
{
    public function index()
    {
        // Implementasi untuk melihat dan memberikan nilai bagi guru
        return Inertia::render('App/Grade/Index');
    }

    public function studentGrades()
    {
        // Implementasi untuk melihat nilai bagi siswa
        return Inertia::render('App/Grade/Student');
    }
}
