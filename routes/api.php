<?php

use App\Http\Controllers\AnagramController;
use App\Http\Controllers\WordBaseController;
use Illuminate\Support\Facades\Route;

Route::post('/word-base/fetch', [WordBaseController::class, 'fetch'])->name('word-base.fetch');

Route::post('/find', [AnagramController::class, 'find'])->name('anagram.find');
