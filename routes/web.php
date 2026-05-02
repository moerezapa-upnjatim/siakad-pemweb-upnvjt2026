<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});

// Resource route untuk CRUD Mahasiswa
// Otomatis membuat route: index, create, store, show, edit, update, destroy
Route::resource('mahasiswa', MahasiswaController::class);
