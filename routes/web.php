<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KarupanController;

Route::POST('/creat',[KarupanController::class,'index']);

Route::get('/',[KarupanController::class,'index']);

Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});

Route::resource('karupan', KarupanController::Class);


Route::get('/index', function () {
    return view('welcome');
});

Route::get('/repair/repair_main', function () {
    return view('repair');
})->name('repairmain');

