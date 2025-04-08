<?php

use Illuminate\Support\Facades\Route;
use \App\Models\Course;

Route::get('/courses', function () {
    return Course::latest()->where('title', 'not ilike', '%operating%')->get('title');
});

Route::get('/courses/{id?}', function (?string $id) {
    $course=Course::findOrFail($id)->title;
    return $course;
});
// ->middleware('auth:sanctum');

Route::fallback(function () {
    return '404'; // no json for now
});
