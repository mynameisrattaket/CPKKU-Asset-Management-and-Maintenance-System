<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\KarupanController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\UsermainController;
use App\Http\Controllers\DataController;

// Route สำหรับแสดงฟอร์มล็อกอิน
Route::view('/login', 'login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', function () {
    return view('dashboard'); // แสดง dashboard
})->middleware('auth'); // ใช้ middleware ตรวจสอบการล็อกอิน

// Route สำหรับ Google Sheets
Route::get('/import-google-sheet', [GoogleSheetController::class, 'importDataFromSheet']);

// Route สำหรับการจัดการ Karupan
Route::get('/', [KarupanController::class, 'index'])->name('index');
Route::get('/create_karupan', [KarupanController::class, 'create'])->name('create_karupan');
Route::post('/insert', [KarupanController::class, 'insert_karupan']);
Route::post('/karupan/destroy', [KarupanController::class, 'destroy'])->name('destroykarupan');
Route::get('delete/{asset_id}', [KarupanController::class, 'delete'])->name('delete');
Route::post('/viewpreeditdata', [KarupanController::class, 'edit_karupan']);
Route::post('/updatedata', [KarupanController::class, 'update_karupan']);
Route::get('/asset/detail/{id}', [KarupanController::class, 'show'])->name('assetdetail');
Route::get('/search', [KarupanController::class, 'search'])->name('searchasset');

// Route สำหรับการจัดการ Repair
Route::get('/repair/repairmain', [RepairController::class, 'dashboard'])->name('repairmain');
Route::get('/repair/repairlist', [RepairController::class, 'index'])->name('repairlist');
Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');
Route::get('/repair/repairprogress', [RepairController::class, 'progress'])->name('repairprogress');
Route::get('/repair/repairdone', [RepairController::class, 'done'])->name('repairdone');
Route::get('/repair/repaircancel', [RepairController::class, 'cancle'])->name('repaircancel');
Route::get('/repair/searchrepair', [RepairController::class, 'search'])->name('searchrepair');
Route::get('/repair/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');
Route::post('/repair/requestrepair/store-repair-request', [RepairController::class, 'storeRepairRequest'])->name('addrequestrepair');
Route::get('/search-assets', [RepairController::class, 'searchAssets'])->name('search.assets');

// Route สำหรับการจัดการยืม
Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');
Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest');
Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');

// Route สำหรับการจัดการข้อมูล
Route::get('/import-excel', [DataController::class, 'showImportPage'])->name('import-excel');
Route::post('/save-data', [DataController::class, 'saveData'])->name('save.data');

// Route สำหรับการจัดการผู้ใช้งาน
Route::get('/manageuser/index', [UsermainController::class, 'index'])->name('manageuser.index');
Route::get('/manageuser/technician', [UsermainController::class, 'technician'])->name('manageuser.technician');
Route::get('/manageuser/employee', [UsermainController::class, 'employee'])->name('manageuser.employee');
Route::get('/manageuser/create', [UsermainController::class, 'create'])->name('manageuser.create');
Route::post('/manageuser/store', [UsermainController::class, 'store'])->name('manageuser.store');
Route::get('/manageuser/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');
Route::put('/manageuser/{id}/update', [UsermainController::class, 'update'])->name('manageuser.update');
Route::delete('/manageuser/{id}/delete', [UsermainController::class, 'destroy'])->name('manageuser.destroy');

// Route อื่น ๆ
Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// ตัวอย่าง Route
Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});
