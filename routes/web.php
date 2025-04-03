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

// กำหนด Route ที่ต้องการการยืนยันตัวตน
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route สำหรับ Karupan
Route::get('/search', [KarupanController::class, 'search'])->name('search');
Route::get('/', [KarupanController::class, 'index'])->name('index');
Route::post('/asset', [KarupanController::class, 'store'])->name('store');
Route::get('/asset/{id}/edit', [KarupanController::class, 'edit'])->name('edit');
Route::put('/asset/{id}', [KarupanController::class, 'update'])->name('update');
Route::delete('/asset/{id}', [KarupanController::class, 'destroy'])->name('asset.destroy');
Route::get('/asset/check-duplicate', [KarupanController::class, 'checkDuplicate']);
Route::get('/export-assets', [KarupanController::class, 'exportExcel']);
Route::get('/search/export', [KarupanController::class, 'exportSearch'])->name('search.export');


// รายการแจ้งซ่อม
Route::get('/repair/repairlist', [RepairController::class, 'index'])->name('repairlist');
Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');
Route::get('/repair/searchrepair', [RepairController::class, 'search'])->name('searchrepair');
Route::get('/repair/export', [RepairController::class, 'export'])->name('repair.export');

// แจ้งซ่อม
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
Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');
// Route สำหรับแสดงฟอร์มการยืมครุภัณฑ์
Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');
// Route สำหรับบันทึกข้อมูลการยืมครุภัณฑ์
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest.store');
// Route สำหรับแสดงรายการการยืมครุภัณฑ์
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'store'])->name('storeborrowrequest.store');
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
// ✅ Route สำหรับอัปเดตคำร้อง
Route::patch('/borrow/{id}', [BorrowRequestController::class, 'update'])->name('borrow.update');

// Route สำหรับอัปเดตสถานะคำร้องขอยืมครุภัณฑ์เป็น "อนุมัติ"
Route::patch('/borrow/{id}/approve', [BorrowRequestController::class, 'approve'])->name('borrow.approve');
// ✅ ทำรายการคืนครุภัณฑ์ → เปลี่ยนเป็น "คืนแล้ว"
Route::patch('/borrow/{id}/return', [BorrowRequestController::class, 'markAsCompleted'])->name('borrow.return');

// Route สำหรับอัปเดตสถานะคำร้องขอยืมครุภัณฑ์เป็น "ปฏิเสธ"
Route::patch('/borrow/{id}/reject', [BorrowRequestController::class, 'reject'])->name('borrow.reject');

Route::get('/borrow/{id}/details', [BorrowRequestController::class, 'details'])->name('borrow.details');
// แก้ไข"
Route::get('/borrow/{id}/edit', [BorrowRequestController::class, 'edit'])->name('borrow.edit');
Route::patch('/borrow/{id}/update', [BorrowRequestController::class, 'update'])->name('borrow.update');
Route::delete('/borrow/{id}/delete', [BorrowRequestController::class, 'destroy'])->name('borrow.delete');
Route::delete('/borrow/{id}/destroy', [BorrowRequestController::class, 'destroy'])->name('borrow.destroy');
Route::get('/borrow/export', [BorrowRequestController::class, 'export'])->name('borrow.export');

// หน้า import
Route::post('/save-data', [DataController::class, 'saveData'])->name('save.data');
// แสดงแบบฟอร์มแก้ไขผู้ใช้งาน
Route::get('/manageuser/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');
Route::put('/manageuser/{id}/update', [UsermainController::class, 'update'])->name('manageuser.update');
// ลบข้อมูลผู้ใช้งาน
Route::delete('/manageuser/{id}/delete', [UsermainController::class, 'destroy'])->name('manageuser.destroy');
Route::post('/manageuser/store', [UsermainController::class, 'store'])->name('manageuser.store');


// เพิ่ม middleware ใน Route เดิมที่ต้องการตรวจสอบ user_type_id
Route::middleware(['auth', 'check_user_type:6,2'])->group(function () {
    // หน้า requestrepair ให้ทั้ง user_type_id = 6 และ 2 เข้าได้
    Route::get('/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');
});

// หน้าอื่น ๆ ที่ user_type_id = 6 เข้าถึงได้
Route::middleware(['auth', 'check_user_type:6'])->group(function () {
    Route::get('/import-excel', [DataController::class, 'showImportPage'])->name('import-excel');
    Route::get('/repairmain', [RepairController::class, 'dashboard'])->name('repairmain');
    Route::get('/manageuser/index', [UsermainController::class, 'index'])->name('manageuser.index');
    Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');
});


// รวม Route สำหรับ Auth ของ Laravel Breeze
set_time_limit(60000);  // Set the max execution time to 300 seconds
require __DIR__.'/auth.php';

