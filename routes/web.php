<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamAssignmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;
use App\Http\Middleware\EnsureTeacher;
use App\Livewire\Student\ExamAttempt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//Login Route

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::get('login/admin', [AuthController::class, 'adminLoginForm'])->name('login.admin');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::post('login/admin', [AuthController::class, 'adminLogin'])->name('login.admin.store');

Route::middleware('auth')->group(function () {

    //Login


    //Dashboard Route
    Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('dashboard.teacher');
    Route::get('student/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard.student');

    //Student Route

    Route::prefix('student')->group(function () {
        Route::resource('/classrooms', ClassroomController::class)->only('show');
        Route::get('/exams', [StudentExamController::class, 'index'])->name('student.exams.index');
        Route::post('/exams/{assignment}/attempt', [StudentExamController::class, 'startAttempt'])->name('student.exams.start');
        Route::get('/exams/attempt/{examTakerId}', ExamAttempt::class)->name('exams.attempt');
    });


    //Teacher Route

    Route::prefix('teacher')->middleware('teacher')->group(function () {
        Route::get('/exams', [ExamController::class, 'indexTeacher'])->name('exams');
        Route::resource('/exams', ExamController::class)->except('index');
        Route::resource('exams.assignments', ExamAssignmentController::class)->scoped()->only('index');
    });

});
