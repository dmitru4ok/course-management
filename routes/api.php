<?php

use Illuminate\Support\Facades\Route;
use \App\Models\Course;
use \App\Http\Controllers\FacultyController;

Route::get('/courses', function () {
    return Course::latest()->where('title', 'not ilike', '%operating%')->get('title');
});

Route::get('/courses/{id?}', function (?string $id) {
    $course=Course::findOrFail($id)->title;
    return $course;
});
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


