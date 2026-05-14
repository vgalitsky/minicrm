<?php

use Illuminate\Support\Facades\Route;
use Mtr\MiniCrm\Http\Controllers\WidgetController;
use \Mtr\MiniCrm\Http\Controllers\Admin\Tickets\IndexController as TicketsIndexController;
use \Mtr\MiniCrm\Http\Controllers\Admin\Tickets\ShowController as TicketsShowController;
use \Mtr\MiniCrm\Http\Controllers\Admin\Tickets\UpdateController as TicketsUpdateController;

Route::prefix('minicrm')
    ->name('minicrm.')
    //->middleware('auth:manager')
    ->group(function () {
        Route::get('/widget', WidgetController::class)->name('widget');
    });

Route::prefix('minicrm/admin')
    ->name('minicrm.admin.')
    ->middleware('web')
    ->group(function () {
        Route::prefix('tickets')
            ->name('tickets.')
            ->group(function (){
                    Route::get('/', TicketsIndexController::class)->name('index');
                    Route::get('/{ticket}', TicketsShowController::class)->name('show');
                    Route::patch('/{ticket}', TicketsUpdateController::class)->name('update');
            });
    });