<?php

use App\Http\Controllers\HuntLogController;
use App\Http\Controllers\WantedCriminalController;
use Illuminate\Support\Facades\Route;

Route::apiResource('criminals', WantedCriminalController::class)
    ->only(['index', 'show'])
    ->whereNumber('criminal');

Route::apiResource('hunts', HuntLogController::class)
    ->except(['update'])
    ->whereNumber('hunt');

Route::patch('hunts/{hunt}', [HuntLogController::class, 'update'])
    ->whereNumber('hunt')
    ->name('hunts.update');
