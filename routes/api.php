<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordBaseController;

Route::post('/word-base/fetch', [WordBaseController::class, 'fetch']);
