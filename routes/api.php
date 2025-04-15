<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FacultyController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudyProgramInstanceController;

// ->middleware('auth:sanctum');


Route::controller(FacultyController::class)->group(function () {
    Route::get('/faculties', 'index');
    Route::get('/faculties/{code}', 'show');
    Route::post('/faculties', 'store');
    Route::patch('/faculties/{code}', 'update');
});

Route::controller(SemesterController::class)->group(function() {
    Route::get('/semesters', 'index');
    Route::get('/semesters/{program}/{year}', 'show');
    Route::post('/semesters', 'store');
    Route::put('/semesters/{program}/{year}', 'update');
});

Route::controller(StudyProgramInstanceController::class)->group(function() {
    Route::get('/study_programs', 'index');
    Route::get('/study_programs/{id}', 'show');
    Route::post('/study_programs', 'store');
    Route::put('/study_programs/{id}', 'update');
});

Route::fallback(function () {
    return '404'; // no json for now
});


