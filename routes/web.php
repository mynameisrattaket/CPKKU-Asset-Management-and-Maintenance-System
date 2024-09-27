<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\KarupanController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\UsermainController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route สำหรับ Google Sheets
Route::get('/import-google-sheet', [GoogleSheetController::class, 'importDataFromSheet']);

// Route สำหรับการจัดการ Karupan
Route::prefix('karupan')->group(function () {
    Route::get('/', [KarupanController::class, 'index'])->name('karupan.index');
    Route::get('/create', [KarupanController::class, 'create'])->name('create_karupan');
    Route::post('/insert', [KarupanController::class, 'insert_karupan']);
    Route::post('/destroy', [KarupanController::class, 'destroy'])->name('destroykarupan');
    Route::get('/delete/{asset_id}', [KarupanController::class, 'delete'])->name('delete');
    Route::post('/viewpreeditdata', [KarupanController::class, 'edit_karupan']);
    Route::post('/updatedata', [KarupanController::class, 'update_karupan']);
    Route::get('/detail/{id}', [KarupanController::class, 'show'])->name('assetdetail');
    Route::get('/search', [KarupanController::class, 'search'])->name('searchasset');
});

// Route สำหรับการแจ้งซ่อม
Route::prefix('repair')->group(function () {
    Route::get('/repairmain', [RepairController::class, 'dashboard'])->name('repairmain');
    Route::get('/repairlist', [RepairController::class, 'index'])->name('repairlist');
    Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');
    Route::get('/repairprogress', [RepairController::class, 'progress'])->name('repairprogress');
    Route::get('/repairdone', [RepairController::class, 'done'])->name('repairdone');
    Route::get('/repaircancel', [RepairController::class, 'cancle'])->name('repaircancel');
    Route::get('/searchrepair', [RepairController::class, 'search'])->name('searchrepair');
    Route::get('/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');
    Route::post('/requestrepair/store-repair-request', [RepairController::class, 'storeRepairRequest'])->name('addrequestrepair');
    Route::get('/search-assets', [RepairController::class, 'searchAssets'])->name('search.assets');
});

// Route สำหรับการยืม
Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');

// Route อื่น ๆ
Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// Route สำหรับการจัดการผู้ใช้งาน
Route::prefix('manageuser')->group(function () {
    Route::get('/index', [UsermainController::class, 'index'])->name('manageuser.index');
    Route::get('/technician', [UsermainController::class, 'technician'])->name('manageuser.technician');
    Route::get('/employee', [UsermainController::class, 'employee'])->name('manageuser.employee');
    Route::get('/create', [UsermainController::class, 'create'])->name('manageuser.create');
    Route::post('/store', [UsermainController::class, 'store'])->name('manageuser.store');
    Route::get('/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');
    Route::put('/{id}/update', [UsermainController::class, 'update'])->name('manageuser.update');
    Route::delete('/{id}/delete', [UsermainController::class, 'destroy'])->name('manageuser.destroy');
});

// Route สำหรับ Import Data
Route::get('/import-excel', [DataController::class, 'showImportPage'])->name('import-excel');
Route::post('/save-data', [DataController::class, 'saveData'])->name('save.data');

// รวม Route สำหรับ Auth ของ Laravel Breeze
require __DIR__.'/auth.php';
