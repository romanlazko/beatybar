<?php

use App\Bots\valeri_beautybar_bot\Http\Controllers\AppointmentController;
use App\Bots\valeri_beautybar_bot\Http\Controllers\CalendarController;
use App\Bots\valeri_beautybar_bot\Http\Controllers\ClientController;
use App\Bots\valeri_beautybar_bot\Http\Controllers\CronController;
use App\Bots\valeri_beautybar_bot\Http\Controllers\EmployeeController;
use App\Bots\valeri_beautybar_bot\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'telegram:valeri_beautybar_bot'])->name('valeri_beautybar_bot.')->group(function () {
    Route::get('/page', function(){
        return view('valeri_beautybar_bot::page');
    })->name('page');

    Route::resource('client', ClientController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('appointment', AppointmentController::class);
});

Route::middleware(['api'])->prefix('api/telegram/{bot}')->get('/cron', CronController::class); 