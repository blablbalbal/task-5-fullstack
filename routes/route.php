<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskScheduleController;

Route::name('taskSchedule')->get('task-shcedule', [TaskScheduleController::class, 'index'])->middleware('auth:api');
Route::name('taskSchedule.create')->post('task-shcedule', [TaskScheduleController::class, 'create'])->middleware('auth:api');
Route::name('taskSchedule.update')->put('task-shcedule', [TaskScheduleController::class, 'updatee'])->middleware('auth:api');
Route::name('taskSchedule.patch')->patch('task-shcedule', [TaskScheduleController::class, 'patch'])->middleware('auth:api');
Route::name('taskSchedule.delete')->delete('task-shcedule', [TaskScheduleController::class, 'destroy'])->middleware('auth:api');

