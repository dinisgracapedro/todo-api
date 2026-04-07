<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return "Testing with api.";
    });
    

    Route::middleware('auth:sanctum')->group(function () {
        
    });
});

