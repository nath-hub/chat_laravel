<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;




Route::get('/', [ViewController::class, 'index']);
Route::post('/logins', [ViewController::class, 'store'])->name('store');
Route::get('/login', [ViewController::class, 'login'])->name('login_get');

Route::get('/verify', [ViewController::class, 'verify'])->name('verify');

Route::post('/otp-verify', [ViewController::class, 'otpVerify'])->name('otp.verify');
Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');

Route::post('abonner', [ViewController::class, 'abonner'])->name('subscription.downgrade');
Route::post('abonne', [ViewController::class, 'abonne'])->name('subscription.subscribe');
Route::post('cancel', [ViewController::class, 'cancel'])->name('subscription.cancel');
Route::post('change', [ViewController::class, 'change'])->name('subscription.change');

// routes/web.php
Route::get('/home', [ViewController::class, 'home'])->name('home');
Route::get('/abonnement', [ViewController::class, 'abonnement'])->name('abonnement');
Route::get('/profil', [ViewController::class, 'profil'])->name('profil');
Route::get('/about', [ViewController::class, 'index'])->name('about');
Route::get('/chat/{id}', [ViewController::class, 'show'])->name('chat.show');
Route::post('/theme/toggle', [ViewController::class, 'toggle'])->name('theme.toggle');

Route::post('/logout', [ViewController::class, 'logout'])->name('logout');

// Envoi de message (appelé par JavaScript)
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

// Bonus
Route::post('/chat/clear', [ChatController::class, 'clearHistory'])->name('chat.clear');
Route::get('/chat/export', [ChatController::class, 'exportHistory'])->name('chat.export');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [ViewController::class, 'index'])->name('settings');
    Route::put('/settings', [ViewController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [ViewController::class, 'reset'])->name('settings.reset');
    Route::post('/sessions/logout-all', [ViewController::class, 'logoutAll'])->name('sessions.logout-all');
    Route::delete('/account', [ViewController::class, 'delete'])->name('account.delete');
});
