<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\KarupanController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\UsermainController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

// หน้าหลัก
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route สำหรับ Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ระบบจัดการ Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route สำหรับการล็อกอิน
Route::view('/login', 'login')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Route สำหรับ Google Sheets
Route::get('/import-google-sheet', [GoogleSheetController::class, 'importDataFromSheet']);

// Route สำหรับการจัดการ Karupan
Route::get('/', [KarupanController::class, 'index'])->name('karupan.index');
Route::get('/create_karupan', [KarupanController::class, 'create'])->name('create_karupan');
Route::post('/insert', [KarupanController::class, 'insert_karupan']);
Route::post('/karupan/destroy', [KarupanController::class, 'destroy'])->name('destroykarupan');
Route::get('delete/{asset_id}', [KarupanController::class, 'delete'])->name('delete');
Route::post('/viewpreeditdata', [KarupanController::class, 'edit_karupan']);
Route::post('/updatedata', [KarupanController::class, 'update_karupan']);

//รายละเอียด ครุภัณฑ์
Route::get('/asset/detail/{id}',[KarupanController::class,'show'])->name('assetdetail');

//ค้นหาครุภัณฑ์
Route::get('/search', [KarupanController::class, 'search'])->name('searchasset');


Route::get('/',[KarupanController::class,'index'])->name('index');

Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});



Route::get('/index', function () {
    return view('index');
});


Route::get('/repair/repairmain', [RepairController::class, 'dashboard'])->name('repairmain');

//รายการเเจ้งซ่อม
Route::get('/repair/repairlist', [RepairController::class, 'index'])->name('repairlist');
Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');

//กำลังดำเนินการ
Route::get('/repair/repairprogress', [RepairController::class, 'progress'])->name('repairprogress');
//ดำเนินการเสร็จสิ้น
Route::get('/repair/repairdone', [RepairController::class, 'done'])->name('repairdone');
//ถูกยกเลิก
Route::get('/repair/repaircancel', [RepairController::class, 'cancle'])->name('repaircancel');
//ค้นหาประวัติการซ่อม
Route::get('/repair/searchrepair', [RepairController::class, 'search'])->name('searchrepair');



// Start page borrow

Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');

// End page borrow

Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// เเจ้งซ่อม
Route::get('/repair/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');

Route::post('/repair/requestrepair/store-repair-request', [RepairController::class, 'storeRepairRequest'])->name('addrequestrepair');
Route::get('/search-assets', [RepairController::class, 'searchAssets'])->name('search.assets');








//ยื่นคำร้อง

use App\Http\Controllers\BorrowRequestController;

/*
Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest');






Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'store'])->name('storeborrowrequest'); */


//เพิ่มข้อมูล

use App\Http\Controllers\AssetController;

Route::get('/import-excel', function () {
    return view('import');
})->name('import-excel');

use App\Http\Controllers\DataController;

Route::get('/import-excel', [DataController::class, 'showImportPage'])->name('import-excel');

Route::post('/save-data', [DataController::class, 'saveData'])->name('save.data');














// จัดการข้อมูลช่าง
Route::get('/setting/technician' , function(){
    return view('setting_technician');
})->name('setting_technician');





//แสดงรายชื่อผู้ใช้งานทั้งหมด
Route::get('/manageuser/index', [UsermainController::class, 'index'])->name('manageuser.index');
Route::get('/manageuser/technician', [UsermainController::class, 'technician'])->name('manageuser.technician');
Route::get('/manageuser/employee', [UsermainController::class, 'employee'])->name('manageuser.employee');

//แสดงแบบฟอร์มสร้างผู้ใช้งานใหม่
Route::get('/manageuser/create', [UsermainController::class, 'create'])->name('manageuser.create');

//เก็บข้อมูลผู้ใช้งานใหม่
Route::post('/manageuser/store', [UsermainController::class, 'store'])->name('manageuser.store');

//แสดงแบบฟอร์มแก้ไขผู้ใช้งาน
Route::get('/manageuser/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');

// อัปเดตข้อมูลผู้ใช้งาน
Route::put('/manageuser/{id}/update', [UsermainController::class, 'update'])->name('manageuser.update');

//ลบข้อมูลผู้ใช้งาน
Route::delete('/manageuser/{id}/delete', [UsermainController::class, 'destroy'])->name('manageuser.destroy');

// Route อื่น ๆ
Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// ตัวอย่าง Route
Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});

// รวม Route สำหรับ Auth ของ Laravel Breeze
require __DIR__.'/auth.php';
