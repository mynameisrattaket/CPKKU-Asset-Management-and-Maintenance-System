<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KarupanController;

Route::POST('/karupan/create',[KarupanController::class,'store'])->name('createkarupan');
Route::POST('/karupan/destroy',[KarupanController::class,'destroy'])->name('destroykarupan');


Route::get('/',[KarupanController::class,'index'])->name('index');

Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});



Route::get('/index', function () {
    return view('welcome');
});


Route::get('/repair/repair_main', function () {
    return view('repairmain');
})->name('repairmain');


Route::get('/repair/repairlist', function () {
    return view('repairlist');
})->name('repairlist');

