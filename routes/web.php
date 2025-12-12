<?php

use App\Models\WordBase;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home', [
        'wordBases' => WordBase::all(['id', 'name', 'url']),
    ]);
})->name('home');

Route::get('/import', function () {
    return Inertia::render('import');
})->name('import');
