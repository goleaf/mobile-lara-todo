<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomePageController;
use App\Livewire\Auth\ForgotPasswordComponent;
use App\Livewire\Auth\LoginComponent;
use App\Livewire\Auth\RegisterComponent;
use App\Livewire\Auth\ResetPasswordComponent;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'guest'])
    ->group(function (): void {
        Route::get('/login', LoginComponent::class)->name('login');
        Route::get('/register', RegisterComponent::class)->name('register');
        Route::get('/forgot-password', ForgotPasswordComponent::class)->name('password.request');
        Route::get('/reset-password/{token}', ResetPasswordComponent::class)->name('password.reset');
    });

Route::middleware(['web', 'auth'])
    ->group(function (): void {
        Route::post('/logout', LogoutController::class)->name('logout');
    });

Route::middleware(['web'])
    ->prefix('')
    ->as('app.')
    ->group(function (): void {
        Route::get('/', HomePageController::class)->name('home');
    });
