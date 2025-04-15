<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FacultyController;
use App\Http\Controllers\SemesterController;

// ->middleware('auth:sanctum');


Route::controller(FacultyController::class)->group(function () {
    Route::get('/faculties', 'index');
    Route::get('/faculties/{code}', 'show');
    Route::post('/faculties', 'store');
    Route::put('/faculties/{code}', 'update');
});

Route::controller(SemesterController::class)->group(function() {
    Route::get('/semesters', 'index');
    Route::get('/semesters/{id}', 'show');
    Route::post('/semesters', 'store');
    Route::put('/semesters/{id}', 'update');
});

Route::fallback(function () {
    return '404'; // no json for now
});


