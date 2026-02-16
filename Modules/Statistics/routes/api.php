<?php

use Illuminate\Support\Facades\Route;
use Modules\Statistics\Http\Controllers\StatisticsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('statistics', [StatisticsController::class, 'show'])->name('statistics.show');
});
