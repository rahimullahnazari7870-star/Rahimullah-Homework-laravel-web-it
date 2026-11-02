<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::middleware(['auth'])->group(function () {

    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    Route::post('/courses', [CourseController::class, 'store'])
        ->name('courses.store');

    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])
        ->name('courses.edit');

    Route::put('/courses/{id}', [CourseController::class, 'update'])
        ->name('courses.update');

    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');

});
