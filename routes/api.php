<?php

use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


    Route::get('/example', function () {
        return response()->json(['message' => 'Hello, API!']);
    });

    Route::post('/example', function (Request $request) {
        return response()->json(['data' => $request->input('data')]);
    });

    Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload');

