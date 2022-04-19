<?php

use Illuminate\Support\Facades\Route;
use MatinEbrahimii\ToDo\Http\Controllers\TaskController;
use MatinEbrahimii\ToDo\Http\Controllers\LabelController;

Route::group([
    'prefix' => 'todo',
    'middleware' => 'auth'
], function () {

    Route::group(['prefix' => 'tasks/'], function () {
        Route::get('', [TaskController::class, 'index']);
        Route::get('{id}', [TaskController::class, 'show'])->name('tasks.show');
        Route::post('', [TaskController::class, 'store']);
        Route::post('{id}/changeStatus', [TaskController::class, 'changeStatus']);
        Route::put('{id}', [TaskController::class, 'update']);
        Route::group(['prefix' => '{id}/labels/'], function () {
            Route::post('', [TaskController::class, 'addLabels']);
            Route::post('assign', [TaskController::class, 'assignLabels']);
        });
    });

    Route::group(['prefix' => 'labels/'], function () {
        Route::get('', [LabelController::class, 'index']);
        Route::get('{id}', [LabelController::class, 'show']);
        Route::post('', [LabelController::class, 'store']);
    });
});
