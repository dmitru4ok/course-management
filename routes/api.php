<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FacultyController;


// ->middleware('auth:sanctum');


Route::controller(FacultyController::class)->group(function () {
    Route::get('/faculties', 'index');
    Route::get('/faculties/{code}', 'show');
    Route::post('/faculties', 'store');
    Route::put('/faculties/{code}', 'update');
});

Route::fallback(function () {
    return '404'; // no json for now
});


