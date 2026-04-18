<?php

use Illuminate\Support\Facades\Route;
use Interdotz\Laravel\Http\Controllers\MailboxProxyController;

Route::prefix('interdotz/mailbox')->middleware('web')->group(function () {
    Route::get('/inbox',          [MailboxProxyController::class, 'inbox']);
    Route::get('/sent',           [MailboxProxyController::class, 'sent']);
    Route::put('/read-all',       [MailboxProxyController::class, 'markAllRead']);
    Route::get('/{mailId}',       [MailboxProxyController::class, 'detail']);
    Route::post('/send',          [MailboxProxyController::class, 'send']);
    Route::put('/{mailId}/read',  [MailboxProxyController::class, 'markAsRead']);
    Route::delete('/{mailId}',    [MailboxProxyController::class, 'delete']);
});
