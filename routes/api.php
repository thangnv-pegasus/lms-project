<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('admin')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [\App\Http\Controllers\CourseController::class,'index']);
        Route::patch('/{id}',[\App\Http\Controllers\CourseController::class,'update']);
        Route::post('/',[\App\Http\Controllers\CourseController::class,'store']);
        Route::delete('/',[\App\Http\Controllers\CourseController::class,'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/',[\App\Http\Controllers\UserController::class,'index']);
        Route::patch('/{id}',[\App\Http\Controllers\UserController::class,'update']);
        Route::post('/',[\App\Http\Controllers\UserController::class,'store']);
        Route::delete('/{ids}',[\App\Http\Controllers\UserController::class,'destroy']);
    });

    Route::prefix('lessons')->group(function () {
        Route::get('/',[\App\Http\Controllers\LessonController::class,'index']);
        Route::patch('/{id}',[\App\Http\Controllers\LessonController::class,'update']);
        Route::post('/',[\App\Http\Controllers\LessonController::class,'store']);
        Route::delete('/{ids}',[\App\Http\Controllers\LessonController::class,'destroy']);
    });

    Route::prefix('/academic-years')->group(function () {
        Route::get('/',[\App\Http\Controllers\AcademicYearController::class,'index']);
        Route::post('/',[\App\Http\Controllers\AcademicYearController::class,'store']);
        Route::delete('/{ids}',[\App\Http\Controllers\AcademicYearController::class,'destroy']);
        Route::patch('/{id}',[\App\Http\Controllers\AcademicYearController::class,'update']);
    });

    Route::prefix('/lesson-tasks')->group(function () {
        Route::get('/',[\App\Http\Controllers\LessonTaskController::class,'index']);
        Route::post('/',[\App\Http\Controllers\LessonTaskController::class,'store']);
        Route::delete('/{ids}',[\App\Http\Controllers\LessonTaskController::class,'destroy']);
        Route::patch('/{id}',[\App\Http\Controllers\LessonTaskController::class,'update']);
    });

})->middleware(['auth:sanctum', 'role:'.\App\Models\User::ROLE_ADMIN]);

Route::prefix('departments')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/',[\App\Http\Controllers\CourseController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\CourseController::class,'show']);
        Route::post('/',[\App\Http\Controllers\CourseController::class,'store']);
        Route::patch('/{id}',[\App\Http\Controllers\CourseController::class,'update']);
    });
});

Route::prefix('auth')->group(function () {
    Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
    Route::post('/forget-password',[\App\Http\Controllers\AuthController::class,'forget-password']);
});
