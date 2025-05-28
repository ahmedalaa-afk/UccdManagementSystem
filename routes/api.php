<?php

use App\Http\Controllers\Admin\Auth\ManagerAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Instructor\AssignmentController;
use App\Http\Controllers\Instructor\AttendanceController;
use App\Http\Controllers\Instructor\Auth\InstructorAuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController as ControllersPostController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\StudentController as StudentHomeController;
use App\Http\Controllers\SuperAdmin\CategoryController as SuperAdminCategoryController;
use App\Http\Controllers\SuperAdmin\CourseController as SuperAdminCourseController;
use App\Http\Controllers\SuperAdmin\InstructorController as SuperAdminInstructorController;
use App\Http\Controllers\SuperAdmin\ManagerController;
use App\Http\Controllers\SuperAdmin\PostController as SuperAdminPostController;
use App\Http\Controllers\SuperAdmin\StudentController as SuperAdminStudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Student\RateController as StudentRateController;

Route::controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware(['auth:sanctum']);
    Route::post('forgetPassword', 'forgetPassword');
    Route::post('resetPassword', 'resetPassword');

    Route::prefix('super_admin')->middleware(['auth:sanctum', 'is_super_admin'])->group(function () {
        Route::prefix('manager')->controller(ManagerController::class)->group(function () {
            Route::post('/store', 'store');
            Route::post('/update', 'update');
            Route::get('/show', 'show');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
        });

        Route::prefix('instructor')->controller(SuperAdminInstructorController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
            Route::get('/getAllInstructors', 'getAllInstructors');
        });

        Route::prefix('student')->controller(SuperAdminStudentController::class)->group(function () {
            Route::post('/import', 'import');
            Route::get('/export', 'export');
            Route::get('/getAllStudents', 'getAllStudents');
        });

        Route::prefix('course')->controller(SuperAdminCourseController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
            Route::get('/getAllEnrollmentStudents', 'getAllEnrollmentStudents');
            Route::post('/acceptStudent', 'acceptStudent');
            Route::post('/rejectStudent', 'rejectStudent');
        });

        Route::prefix('category')->controller(SuperAdminCategoryController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
        });

        Route::prefix('post')->controller(SuperAdminPostController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
        });
    });

    Route::prefix('manager')->middleware(['auth:sanctum', 'is_manager'])->group(function () {
        Route::prefix('instructor')->controller(InstructorController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
            Route::get('/getAllInstructors', 'getAllInstructors');
        });

        Route::prefix('student')->controller(StudentController::class)->group(function () {
            Route::post('/import', 'import');
            Route::get('/export', 'export');
            Route::get('/getAllStudents', 'getAllStudents');
        });

        Route::prefix('course')->controller(CourseController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
            Route::get('/getAllEnrollmentStudents', 'getAllEnrollmentStudents');
            Route::post('/acceptStudent', 'acceptStudent');
            Route::post('/rejectStudent', 'rejectStudent');
        });

        Route::prefix('category')->controller(CategoryController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
        });

        Route::prefix('post')->controller(PostController::class)->group(function () {
            Route::post('/store', 'store');
            Route::get('/show', 'show');
            Route::post('/update', 'update');
            Route::post('/delete', 'delete');
            Route::post('/restore', 'restore');
        });
    });
    Route::prefix('instructor')->middleware(['auth:sanctum', 'is_instructor'])->group(function () {
        Route::post('login', 'login')->withoutMiddleware(['auth:sanctum', 'is_instructor']);
        Route::post('logout', 'logout');

        Route::prefix('attendance')->controller(AttendanceController::class)->group(function () {
            Route::post('/store', 'store');
        });
        Route::prefix('assignment')->controller(AssignmentController::class)->group(function () {
            Route::post('/store', 'store');
        });
    });

    Route::prefix('student')->middleware(['auth:sanctum', 'is_student'])->controller(StudentHomeController::class)->group(function () {
        Route::post('login', 'login')->withoutMiddleware(['auth:sanctum', 'is_student']);
        Route::post('logout', 'logout');

        Route::prefix('course')->controller(StudentCourseController::class)->group(function () {
            Route::get('/getAvailableCourses', 'getAvailableCourses');
            Route::post('/enroll', 'enroll');
            Route::post('/getCourseStatistics', 'getCourseStatistics');
        });

        Route::prefix('interest')->group(function () {
            Route::post('/store', 'storeInterests');
        });
        Route::prefix('rate')->controller(StudentRateController::class)->group(function () {
            Route::post('/store', 'store');
        });
    });

    Route::prefix('posts')->middleware(['auth:sanctum'])->controller(ControllersPostController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/show', 'show');
    });
    Route::prefix('comment')->middleware(['auth:sanctum'])->controller(CommentController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/show', 'show');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    });

    Route::prefix('like')->middleware(['auth:sanctum'])->controller(LikeController::class)->group(function () {
        Route::post('/add', 'add');
    });
});
