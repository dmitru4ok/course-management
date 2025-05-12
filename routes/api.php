<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FacultyController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudyProgramController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function() {

    Route::controller(AuthController::class)->group(function() { // tested
        Route::post('/register', 'register')->middleware('role:A');
        Route::get('/me', 'whoami');
        Route::post('/refresh', 'refresh');
        Route::post('/logout', 'logout');
        Route::get('/me/study_program', 'user_study_program');
    });

    Route::controller(FacultyController::class)->group(function () { // tested
        Route::get('/faculties', 'index');
        Route::get('/faculties/{code}', 'show');
        Route::post('/faculties', 'store')->middleware('role:A');
        Route::patch('/faculties/{code}', 'update')->middleware('role:A');
    });

    Route::controller(SemesterController::class)->group(function() {
        Route::get('/semesters', 'index');
        Route::get('/semesters/{program}/{year}', 'show');
        Route::post('/semesters', 'store')->middleware('role:A');
        Route::put('/semesters/{program}/{year}', 'update')->middleware('role:A');
    });

    Route::controller(StudyProgramController::class)->group(function() { // testing
        Route::get('/study_programs', 'index');
        Route::get('/study_programs/instances', 'index_instances');
        Route::get('/study_programs/{code}', 'show_study_program_by_id');
        Route::get('/study_programs/{code}/instances', 'show_by_code_instances');
        Route::get('/study_programs/instances/{year}', 'show_instances_by_year');
        Route::get('/study_programs/{code}/instances/{year}', 'show_specific');
    
        Route::post('/study_programs', 'create_study_program')
            ->name('study_program.create')
            ->middleware('role:A');

        Route::post('/study_programs/instances', 'create_study_program_instance')
            ->name('study_program.instantiate')
            ->middleware('role:A');
    
        Route::delete('/study_programs/{code}', 'devalidate_program');
       
        Route::patch('/study_programs/{code}', 'update')->middleware('role:A');
    });
});

Route::fallback(function () {
    return response(["message" => "invalid endpoint"], 404);
});




