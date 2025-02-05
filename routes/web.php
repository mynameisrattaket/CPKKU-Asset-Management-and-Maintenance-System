<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\KarupanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\UsermainController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/technician-repairs', [RepairController::class, 'technicianRepairs'])->name('technician.repairs');
});

// หน้า Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// กำหนด Route ที่ต้องการการยืนยันตัวตน
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route สำหรับ Karupan
Route::get('/search', [KarupanController::class, 'search'])->name('search');
Route::get('/asset', [KarupanController::class, 'index'])->name('index');
Route::post('/asset', [KarupanController::class, 'store'])->name('store');
Route::get('/asset/{id}/edit', [KarupanController::class, 'edit'])->name('edit');
Route::put('/asset/{id}', [KarupanController::class, 'update'])->name('update');
Route::delete('/asset/{id}', [KarupanController::class, 'destroy'])->name('destroy');

// รายการแจ้งซ่อม
Route::get('/', [RepairController::class, 'dashboard'])->name('repairmain');
Route::get('/repair/repairlist', [RepairController::class, 'index'])->name('repairlist');
Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');
Route::get('/repair/searchrepair', [RepairController::class, 'search'])->name('searchrepair');

// แจ้งซ่อม
Route::get('/repair/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');
Route::post('/repair/requestrepair/store-repair-request', [RepairController::class, 'storeRepairRequest'])->name('addrequestrepair');
Route::get('/search-assets', [RepairController::class, 'searchAssets'])->name('search.assets');

// หน้าเบิก
Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');
Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// ยื่นคำร้องยืมครุภัณฑ์
// Route สำหรับแสดงฟอร์มการยืมครุภัณฑ์
Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');
// Route สำหรับบันทึกข้อมูลการยืมครุภัณฑ์
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest.store');
// Route สำหรับแสดงรายการการยืมครุภัณฑ์
Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');
// Route สำหรับหน้าประวัติการยืม
Route::get('/borrowhistory', [BorrowRequestController::class, 'borrowHistory'])->name('borrowhistory');
// แสดงรายการรอดำเนินการ
Route::get('/borrowpending', [BorrowRequestController::class, 'pendingBorrows'])->name('borrowpending');
// อัปเดตสถานะคำร้อง
Route::put('/borrow/update/{id}', [BorrowRequestController::class, 'updateBorrowStatus'])->name('updateBorrowStatus');
// เสร็จสิ้นคำร้อง
Route::get('/borrow/completed', [BorrowRequestController::class, 'completedBorrows'])->name('borrowcompleted');
// คำร้องถูกปฏิเสธ
Route::get('/borrow/rejected', [BorrowRequestController::class, 'rejectedBorrows'])->name('borrowrejected');
//Route สำหรับเค้นหาข้อมูลประวัติการยืมครุภัณฑ์
Route::get('/searchasset', [AssetController::class, 'searchAsset'])->name('searchasset');


// หน้า import
Route::get('/import-excel', [DataController::class, 'showImportPage'])->name('import-excel');
Route::post('/save-data', [DataController::class, 'saveData'])->name('save.data');

// จัดการข้อมูลช่าง
Route::get('/setting/technician', function () {
    return view('setting_technician');
})->name('setting_technician');

// แสดงรายชื่อผู้ใช้งานทั้งหมด
Route::get('/manageuser/index', [UsermainController::class, 'index'])->name('manageuser.index');
Route::get('/manageuser/technician', [UsermainController::class, 'technician'])->name('manageuser.technician');
Route::get('/manageuser/employee', [UsermainController::class, 'employee'])->name('manageuser.employee');

// แสดงแบบฟอร์มสร้างผู้ใช้งานใหม่
Route::get('/manageuser/create', [UsermainController::class, 'create'])->name('manageuser.create');
Route::post('/manageuser/store', [UsermainController::class, 'store'])->name('manageuser.store');

// แสดงแบบฟอร์มแก้ไขผู้ใช้งาน
Route::get('/manageuser/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');
Route::put('/manageuser/{id}/update', [UsermainController::class, 'update'])->name('manageuser.update');

// ลบข้อมูลผู้ใช้งาน
Route::delete('/manageuser/{id}/delete', [UsermainController::class, 'destroy'])->name('manageuser.destroy');

// รวม Route สำหรับ Auth ของ Laravel Breeze

require __DIR__.'/auth.php';
