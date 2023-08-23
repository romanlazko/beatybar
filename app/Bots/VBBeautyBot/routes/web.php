<?php

use App\Bots\VBBeautyBot\Http\Controllers\AppointmentController;
use App\Bots\VBBeautyBot\Http\Controllers\CalendarController;
use App\Bots\VBBeautyBot\Http\Controllers\ClientController;
use App\Bots\VBBeautyBot\Http\Controllers\CronController;
use App\Bots\VBBeautyBot\Http\Controllers\EmployeeController;
use App\Bots\VBBeautyBot\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'telegram:VBBeautyBot'])->name('VBBeautyBot.')->group(function () {
    Route::get('/page', function(){
        return view('VBBeautyBot::page');
    })->name('page');

    Route::resource('client', ClientController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('appointment', AppointmentController::class);
});

Route::middleware(['api'])->prefix('api/telegram/{bot}')->get('/cron', CronController::class); 