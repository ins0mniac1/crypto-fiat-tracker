<?php

use App\Http\Controllers\API\Guest\HomeController;
use App\Http\Controllers\API\Guest\SaveUserForNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'guest'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/notify', [SaveUserForNotificationController::class, 'store'])->name('save-user-for-notification');
});
