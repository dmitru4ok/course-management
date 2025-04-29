<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FacultyController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudyProgramController;

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

Route::controller(StudyProgramController::class)->group(function() {
    Route::get('/study_programs', 'index');
    Route::get('/study_programs/instances', 'index_instances');
    Route::get('/study_programs/{code}', 'show_study_program_by_id');
    Route::get('/study_programs/{code}/instances', 'show_by_code_instances');
    Route::get('/study_programs/instances/{year}', 'show_instances_by_year');
    Route::get('/study_programs/{code}/instances/{year}', 'show_specific');

    Route::post('/study_programs', 'create_study_program');
    Route::post('/study_programs/instances', 'create_study_program_instance');

    Route::delete('/study_programs/{code}', 'devalidate_program');
   
    Route::patch('/study_programs/{code}', 'update');
});

Route::fallback(function () {
    return response(["message" => "invalid endpoint"], 404);
});


