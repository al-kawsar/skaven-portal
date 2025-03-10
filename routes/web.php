<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\ClassController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\ExamController;
use App\Http\Controllers\Dashboard\ScheduleController;
use App\Http\Controllers\Dashboard\InventoryController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\GradeController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {

    Route::name('login.')->prefix('login')->controller(LoginController::class)->middleware('guest')->group(function () {
        Route::get('/', 'showFormLogin')->name('index');
        Route::post('/', 'doLogin')->name('post');
    });

    Route::match(['get', 'post'], 'logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::get('/settings/account', [DashboardController::class, 'accountSettings'])->name('settings.account');
Route::get('/settings/security', [DashboardController::class, 'accountSecurity'])->name('settings.security');

Route::get('/test-auth', function () {
    return ['loggedIn' => auth()->check()];
});

Route::redirect('/', '/dashboard');

Route::name('app.')->middleware('auth')->group(
    function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::resource('/schedules', ScheduleController::class)->parameters(['schedules' => 'id:id']);
        Route::get('/class_inventory', [InventoryController::class, 'classInventory'])->name('class_inventory.index');
        Route::resource('/exams', ExamController::class)->parameters(['exams' => 'id:id']);
        Route::resource('/subjects', SubjectController::class)->parameters(['subjects' => 'id:id']);

        // Admin Routes
        Route::middleware(['role:admin'])->group(function () {
            Route::resource('/students', StudentController::class)->parameters(['students' => 'id:id']);
            Route::resource('/teachers', TeacherController::class)->parameters(['teachers' => 'id:id']);
            Route::resource('/classes', ClassController::class)->parameters(['classes' => 'id:id']);
            Route::resource('/inventory', InventoryController::class)->parameters(['inventory' => 'id:id']);
            Route::resource('/reports', ReportController::class)->parameters(['reports' => 'id:id']);
        });


        // Teacher Routes
        Route::middleware(['role:admin,teacher'])->group(function () {
            Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
        });

        // Student Routes
        Route::middleware(['role:student'])->group(function () {
            Route::get('/my_grades', [GradeController::class, 'studentGrades'])->name('student.grades.index');
        });

    }
);
