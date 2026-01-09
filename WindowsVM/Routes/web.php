<?php

use Illuminate\Support\Facades\Route;

// No public web routes needed for manual WindowsVM service.
Route::get('/windowsvm/ping', fn () => response()->json(['ok' => true]));
