<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ReportController;

// by default, akan menampilkan layout mahasiswa
Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});
Route::get('/report', [ReportController::class, 'index'])
    ->name('report.index');

// Resource route untuk CRUD Mahasiswa
// Otomatis membuat route: index, create, store, show, edit, update, destroy
Route::resource('mahasiswa', MahasiswaController::class);