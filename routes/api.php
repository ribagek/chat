<?php

use Illuminate\Support\Facades\Route;
use Mdeskorg\Chat\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::middleware(['auth'])->group(function () {

/** CHATS */
Route::get('chats', [ChatController::class, 'index']);
Route::post('chats', [ChatController::class, 'index']);
Route::get('chats/{chat}', [ChatController::class, 'show']);
Route::post('chats/{chat}/set-star', [ChatController::class, 'star']);
Route::post('chats/{chat}/set-description', [ChatController::class, 'description']);

/** MESSAGES */
Route::get('chats/{chat}/messages', [ChatController::class, 'messages']);
Route::post('chats/{chat}/messages', [ChatController::class, 'store']);

// });
