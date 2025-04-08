<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Models\Course;

Route::get('/course/{id?}', function (Request $request, ?int $id = null) {
    $course=Course::find($id)->title;
    return var_dump($course);
});
// ->middleware('auth:sanctum');
