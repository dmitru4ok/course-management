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
    Route::get('/study_programs/{code}', 'show_by_code');
    Route::get('/study_programs/year/{year}', 'show_by_year');
    Route::post('/study_programs', 'store');
    Route::patch('/study_programs/{code}', 'update');
});

Route::fallback(function () {
    return response(["message" => "invalid endpoint"], 404);
});


