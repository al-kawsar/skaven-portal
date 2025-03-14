<?php

use App\Http\Controllers\Dashboard\ClassController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'getData'])->name('api.students');
Route::get('/teachers', [TeacherController::class, 'getData'])->name('api.teachers');
Route::get('/classes', [ClassController::class, 'getData'])->name('api.classes');
Route::get('/exams', [ExamController::class, 'getData'])->name('api.exams');
Route::get('/exams/{exam_id}', [ExamController::class, 'getDataById'])->name('api.exams.id');
Route::get('/subjects', [SubjectController::class, 'getData'])->name('api.subjects');
