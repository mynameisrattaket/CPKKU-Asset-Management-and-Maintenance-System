<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KarupanController;
use App\Http\Controllers\RepairController;
use App\Http\Liveeire\Assetdetail;
use App\Http\Controllers\UsermainController;


Route::get('/create_karupan',[KarupanController::class,'create'])->name('create_karupan');
Route::post('/insert',[KarupanController::class,'insert_karupan']);
Route::POST('/karupan/destroy',[KarupanController::class,'destroy'])->name('destroykarupan');
Route::get('delete/{asset_id}',[KarupanController::class,'delete'])->name('delete');
Route::POST('/viewpreeditdata',[KarupanController::class,'edit_karupan']);

// Route::get('TestEdit/{asset_id}',[KarupanController::class,'edit_karupan'])->name('editkarupan');
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


Route::get('/repair/repair_main', function () {
    return view('repairmain');
})->name('repairmain');

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







//ยื่นคำร้อง

use App\Http\Controllers\BorrowRequestController;


Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest');






Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'store'])->name('storeborrowrequest');


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




Route::get('/manageuser', [UsermainController::class, 'index'])->name('manageuser.index');
Route::get('/manageuser/create', [UsermainController::class, 'create'])->name('manageuser.create');
Route::post('/manageuser', [UsermainController::class, 'store'])->name('manageuser.store');
Route::get('/manageuser/{id}/edit', [UsermainController::class, 'edit'])->name('manageuser.edit');
Route::put('/manageuser/{id}', [UsermainController::class, 'update'])->name('manageuser.update');
Route::delete('/manageuser/{id}', [UsermainController::class, 'destroy'])->name('manageuser.destroy');




