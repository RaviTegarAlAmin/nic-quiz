<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
});

//Login Route

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::get('login/admin', [AuthController::class, 'adminLoginForm'])->name('login.admin');
Route::post('login',[AuthController::class, 'login'])->name('login.store');
Route::post('login/admin', [AuthController::class, 'adminLogin'])->name('login.admin.store');


Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
Route::get('teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('dashboard.teacher');
Route::get('student/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard.student');
