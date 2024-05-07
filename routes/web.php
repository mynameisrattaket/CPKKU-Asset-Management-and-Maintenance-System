<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KarupanController;

Route::get('/',[KarupanController::class,'index']);
Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});

Route::resource('karupan', KarupanController::Class);



Route::get('/index', function () {
    return view('welcome');
});

