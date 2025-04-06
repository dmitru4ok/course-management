<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user/{id?}', function (Request $request, ?int $id = null) {
    return 'userss' . $id;
});
// ->middleware('auth:sanctum');
