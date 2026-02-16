<?php

use Illuminate\Support\Facades\Route;
use Modules\Statistics\Http\Controllers\StatisticsController;

Route::middleware(['auth'])->group(function () {
    Route::get('note-statistics', [StatisticsController::class, 'index'])->name('note.statistics');
});
