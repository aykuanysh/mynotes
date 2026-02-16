<?php

use Illuminate\Support\Facades\Route;
use Modules\Export\Http\Controllers\ExportController;

Route::middleware(['auth'])->group(function () {
    Route::post('notes-export', [ExportController::class, 'export'])->name('notes.export');
    Route::get('notes-export/{filename}', [ExportController::class, 'download'])->name('notes.export.download');
});
