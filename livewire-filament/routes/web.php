<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: [HomeController::class, 'index']);