<?php

use App\Events\NewTradeEvent;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    'chat',
    [ChatController::class, 'index']
);

Route::get('sendM', SendMessageController::class);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['middlewire' => 'auth'], function(){
Route::get('tt', TestController::class)->middleware('can:dash_view')->name('tt');
// });
