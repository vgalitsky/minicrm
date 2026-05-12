<?php

use Illuminate\Support\Facades\Route;
use Mtr\MiniCrm\Http\Controllers\Api\V1\Tickets\StatisticsController;
use Mtr\MiniCrm\Http\Controllers\Api\V1\TicketsController;

Route::prefix('minicrm/api/v1')
    ->name('minicrm.api.v1.')
    ->group(function () {
        Route::prefix('tickets')
            ->name('tickets.')
            ->group(function () {
                // Route::apiResource('/', TicketsController::class)->only(['index', 'show', 'store', 'update' ])
                //     ->name('index', 'tickets');

                Route::apiResource('/statistics', StatisticsController::class)->only(['index'])
                    ->name('index', 'statistics');
            });
    });
