<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CourseController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'show']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'update']);
        Route::post('/', [\App\Http\Controllers\Admin\CourseController::class, 'store']);
        Route::delete('/', [\App\Http\Controllers\Admin\CourseController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update']);
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store']);
        Route::delete('/{ids}', [\App\Http\Controllers\Admin\UserController::class, 'destroy']);
    });

    Route::prefix('lessons')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LessonController::class, 'index']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\LessonController::class, 'update']);
        Route::post('/', [\App\Http\Controllers\Admin\LessonController::class, 'store']);
        Route::delete('/{ids}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy']);
    });

    Route::prefix('/academic-years')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AcademicYearController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\AcademicYearController::class, 'store']);
        Route::delete('/{ids}', [\App\Http\Controllers\Admin\AcademicYearController::class, 'destroy']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\AcademicYearController::class, 'update']);
    });

    Route::prefix('/lesson-tasks')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LessonTaskController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\LessonTaskController::class, 'store']);
        Route::delete('/{ids}', [\App\Http\Controllers\Admin\LessonTaskController::class, 'destroy']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\LessonTaskController::class, 'update']);
    });

})->middleware(['auth:sanctum', 'role:'.\App\Models\User::ROLE_ADMIN]);

Route::prefix('departments')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CourseController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\Admin\CourseController::class, 'store']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'update']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/forget-password', [\App\Http\Controllers\Admin\AuthController::class, 'forget-password']);
});
