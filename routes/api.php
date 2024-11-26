<?php

use App\Http\Controllers\User\UserSubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\AcademicYearController;

Route::prefix('admin')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::patch('/{id}', [CourseController::class, 'update']);
        Route::post('/', [CourseController::class, 'store']);
        Route::delete('/', [CourseController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::delete('/', [UserController::class, 'destroy']);
    });

    Route::prefix('lessons')->group(function () {
        Route::get('/', [LessonController::class, 'index']);
        Route::patch('/{id}', [LessonController::class, 'update']);
        Route::post('/', [LessonController::class, 'store']);
        Route::delete('/', [LessonController::class, 'destroy']);
    });

    Route::prefix('/academic-years')->group(function () {
        Route::get('/', [AcademicYearController::class, 'index']);
        Route::get('/{academicYear}',[AcademicYearController::class, 'show']);
        Route::post('/', [AcademicYearController::class, 'store']);
        Route::delete('/', [AcademicYearController::class, 'destroy']);
        Route::patch('/{academicYear}', [AcademicYearController::class, 'update']);
    });

    Route::prefix('/lesson-tasks')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LessonTaskController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\LessonTaskController::class, 'store']);
        Route::delete('/', [\App\Http\Controllers\Admin\LessonTaskController::class, 'destroy']);
        Route::patch('/{id}', [\App\Http\Controllers\Admin\LessonTaskController::class, 'update']);
    });

    Route::prefix('exercises')->group(function () {
        Route::get('/',[\App\Http\Controllers\Admin\ExerciseController::class, 'index']);
        Route::get('/{exercise}',[\App\Http\Controllers\Admin\ExerciseController::class, 'show']);
        Route::post('/',[\App\Http\Controllers\Admin\ExerciseController::class, 'store']);
        Route::delete('/', [\App\Http\Controllers\Admin\ExerciseController::class, 'destroy']);
        Route::patch('/{exercise}', [\App\Http\Controllers\Admin\ExerciseController::class, 'update']);
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

Route::prefix('students')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/',[\App\Http\Controllers\User\UserCourseController::class, 'index']);
        Route::get('/{course}',[\App\Http\Controllers\User\UserCourseController::class, 'show']);
        Route::post('/',[\App\Http\Controllers\User\UserCourseController::class, 'store']);
    });

    Route::prefix('exercise')->group(function () {
        Route::get('/',[\App\Http\Controllers\User\UserExerciseController::class, 'index']);
        Route::get('/{exercise}',[\App\Http\Controllers\User\UserExerciseController::class, 'show']);
    });

    Route::prefix('submission')->group(function () {
       Route::get('',[UserSubmissionController::class, 'index']);
       Route::post('/',[UserSubmissionController::class,'store']);
    });
})->middleware(['auth:sanctum']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/forget-password', [\App\Http\Controllers\Admin\AuthController::class, 'forget-password']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::patch('/me',[\App\Http\Controllers\Admin\AuthController::class, 'updateProfile']);
        Route::get('/me',[\App\Http\Controllers\Admin\AuthController::class, 'me']);
        Route::patch('/change-password',[\App\Http\Controllers\Admin\AuthController::class,'changePassword']);
    });
});

