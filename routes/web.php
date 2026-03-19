<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeachingController;
use App\Http\Controllers\AdminImportExportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamAssignmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\TeacherClassroomController;
use App\Http\Controllers\TeacherGradeController;
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

    //Student Route

    Route::prefix('student')->middleware('student')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard.student');
        Route::resource('/classrooms', ClassroomController::class)->only('show');
        Route::prefix('exams')->group(function () {
            Route::get('/', [StudentExamController::class, 'index'])->name('student.exams.index');
            Route::post('/{assignment}/attempt', [StudentExamController::class, 'startAttempt'])->name('student.exams.start');
            Route::get('/attempt/{examTakerId}', ExamAttempt::class)->name('exams.attempt');
            Route::get('/assignment/{assignment}/result', [StudentExamController::class, 'result'])->name('student.exams.result');
        });
    });


    //Teacher Route

    Route::prefix('teacher')->middleware('teacher')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'teacherDashboard'])->name('dashboard.teacher');
        Route::resource('/exams', ExamController::class)->except('index');
        Route::resource('exams.assignments', ExamAssignmentController::class)->scoped()->only('index');
        Route::prefix('exams')->group(function () {
            Route::get('/', [ExamController::class, 'indexTeacher'])->name('exams');
            Route::get('{exam}/grades', [TeacherGradeController::class, 'index'])->name('teacher.exams.grade.index');
            Route::get('{exam}/assignment/{assignment}/correction', [TeacherGradeController::class, 'correction'])->name('teacher.exams.grade.correction');

        });
        Route::prefix('classrooms')->group(function () {
            Route::get('/', [TeacherClassroomController::class, 'index'])->name('teacher.classrooms');
        });
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('/teachers', TeacherController::class);
        Route::resource('/students', StudentController::class);
        Route::resource('/classrooms', \App\Http\Controllers\Admin\ClassroomController::class);
        Route::resource('/courses', CourseController::class);
        Route::resource('/teachings', TeachingController::class);

        //Import and Export for Admin Route
        Route::get('/download/classroom/{classroomId}/students', [AdminImportExportController::class, 'exportClassroomStudents'])->name('download.classroom.students');
    });

});
