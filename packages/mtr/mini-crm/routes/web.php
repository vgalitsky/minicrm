<?php

use Illuminate\Support\Facades\Route;
use Mtr\MiniCrm\Http\Controllers\WidgetController;

Route::prefix('minicrm')
    ->name('minicrm.')
    //->middleware('auth:manager')
    ->group(function () {
        Route::get('/widget', WidgetController::class)->name('widget');
    });

Route::prefix('minicrm/admin')
    ->name('minicrm.admin.')
    ->group(function () {
        Route::prefix('tickets')
            ->name('tickets.')
            ->group(function (){
                    Route::get('/', [\Mtr\MiniCrm\Http\Controllers\Admin\Tickets\IndexController::class, 'index'])->name('index');
                    // Route::get('/{ticket}', [\Mtr\MiniCrm\Http\Controllers\Admin\TicketsController::class, 'show'])->name('show');
                    // Route::patch('/{ticket}', [\Mtr\MiniCrm\Http\Controllers\Admin\TicketsController::class, 'update'])->name('update');
            });
    });