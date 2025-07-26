<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
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
    Route::resource('student/classrooms', ClassroomController::class)->only('show');
    Route::get('student/exams', [ExamController::class, 'indexStudent'])->name('exams.student');

    //Teacher Route
    Route::get('teacher/exams', [ExamController::class, 'indexTeacher'])->name('exams.teacher');
    Route::resource('teacher/exams', ExamController::class)->except('index');
});
