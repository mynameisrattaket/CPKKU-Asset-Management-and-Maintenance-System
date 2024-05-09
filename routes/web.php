<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KarupanController;

Route::get('/create',[KarupanController::class,'create']);
Route::post('/insert',[KarupanController::class,'insert_karupan']);
Route::POST('/karupan/destroy',[KarupanController::class,'destroy'])->name('destroykarupan');
Route::get('delete/{asset_id}',[KarupanController::class,'delete'])->name('delete');
Route::get('/edit/{asset_id}',[KarupanController::class,'edit'])->name('edit_karupan');
Route::post('/update',[KarupanController::class,'update'])->name('update_karupan');
Route::post('/show',[KarupanController::class,'show'])->name('show');

Route::get('/',[KarupanController::class,'index'])->name('index');

Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});



Route::get('/index', function () {
    return view('index');
});


Route::get('/repair/repair_main', function () {
    return view('repairmain');
})->name('repairmain');


Route::get('/repair/repairlist', function () {
    return view('repairlist');
})->name('repairlist');


Route::get('/repair/repairprogress', function () {
    return view('repairprogress');
})->name('repairprogress');


Route::get('/repair/repairdone', function () {
    return view('repairdone');
})->name('repairdone');

// Start page borrow

Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');

// End page borrow