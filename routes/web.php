<?php

use App\Http\Controllers\SendSmsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-sms/{cellphone}', SendSmsController::class);
