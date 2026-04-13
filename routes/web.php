<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->prefix('')
    ->as('app.')
    ->group(function (): void {
        Route::get('/', HomePageController::class)->name('home');
    });
