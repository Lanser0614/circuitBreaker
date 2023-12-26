<?php

use App\MoonShine\Controllers\CustomController;
use Illuminate\Support\Facades\Route;

Route::post('/custom', CustomController::class)
    ->name('custom.store');
