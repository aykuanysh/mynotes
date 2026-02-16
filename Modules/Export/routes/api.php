<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\ExportController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('exports', [ExportController::class, 'store'])->name('export.store');
    Route::get('exports/{filename}', [ExportController::class, 'show'])->name('export.show');
});
