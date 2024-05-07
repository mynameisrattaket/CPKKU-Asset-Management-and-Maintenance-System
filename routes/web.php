<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/repair/repair_main', function () {
    return view('repair');
})->name('repairmain');

