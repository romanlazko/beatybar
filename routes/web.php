<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Romanlazko\Telegram\Models\Bot;
use Romanlazko\Telegram\Providers\TelegramServiceProvider;
use App\Bots\valeri_beautybar_bot\Models\Appointment;
use App\Bots\valeri_beautybar_bot\Models\AppointmentExport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/export_appointment', function () {
    Appointment::all()->each(function ($appointment) {
        AppointmentExport::create([
            'client_id' => $appointment->client_id,
            'employee_id' => 1,
            'service_id' => 1,
            'date' => $appointment->schedule->date,
            'term' => $appointment->schedule->term,
            'price' => $appointment->price,
            'status' => $appointment->status,
            'created_at' => $appointment->created_at,
            'updated_at' => $appointment->updated_at,
        ]);
    });
});

Route::get('/dashboard', function () {

    session()->put('current_bot', Bot::first()?->id);

    // return redirect(TelegramServiceProvider::BOT);
    return view('dashboard');


})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
