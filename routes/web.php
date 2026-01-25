<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

// перенаправляем с главной страницы на список заметок
Route::get('/', function () {
    return redirect()->route('notes.index');
});

// автоматически создает 7 маршрутов CRUD и связывает с методами NoteContoller
Route::resource('notes', NoteController::class);