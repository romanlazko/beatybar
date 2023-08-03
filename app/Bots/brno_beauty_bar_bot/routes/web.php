<?php

use App\Bots\brno_beauty_bar_bot\Http\Controllers\AppointmentController;
use App\Bots\brno_beauty_bar_bot\Http\Controllers\CalendarController;
use App\Bots\brno_beauty_bar_bot\Http\Controllers\ClientController;
use App\Bots\brno_beauty_bar_bot\Http\Controllers\EmployeeController;
use App\Bots\brno_beauty_bar_bot\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'telegram:brno_beauty_bar_bot'])->name('brno_beauty_bar_bot.')->group(function () {
    Route::get('/page', function(){
        return view('brno_beauty_bar_bot::page');
    })->name('page');

    Route::resource('client', ClientController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('appointment', AppointmentController::class);
});