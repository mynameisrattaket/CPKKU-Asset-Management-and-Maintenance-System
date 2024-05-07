<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layoutmenu');
});
Route::get('/index', function () {
    return view('welcome');
});

