<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\GoogleSheetsController;
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

// การนำเข้าข้อมูลจาก Google Sheet
Route::get('/import-sheet', [GoogleSheetController::class, 'importData']);

// API
Route::get('/update-google-sheets', function () {
    $response = Http::get('https://spreadsheets.google.com/feeds/list/2PACX-1vRA4JiIvbzipooeNQEkqD3mVEM-t42tWWLN1Iwe-WQgYKUI1HE5_ceECrWR3ra7qrf1Jxt-S67pYw6G/od6/public/values?alt=json');
    $data = $response->json();

    foreach ($data['feed']['entry'] as $entry) {
        DB::table('request_detail')->updateOrInsert(
            ['request_detail_id' => $entry['gsx$requestdetailid']['$t']],
            [
                'asset_image' => $entry['gsx$assetimage']['$t'],
                'asset_number' => $entry['gsx$assetnumber']['$t'],
                'asset_name' => $entry['gsx$assetname']['$t'],
                'request_repair_id' => $entry['gsx$requestrepairid']['$t'],
                'asset_symptom_detail' => $entry['gsx$assetsymptomdetail']['$t'],
                'location' => $entry['gsx$location']['$t'],
                'request_repair_note' => $entry['gsx$requestrepairnote']['$t'],
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }

    return 'Data Updated Successfully!';
});

// Route สำหรับ Karupan
Route::get('/import-google-sheets', [GoogleSheetsController::class, 'import']);
Route::get('/create_karupan', [KarupanController::class, 'create'])->name('create_karupan');
Route::post('/insert', [KarupanController::class, 'insert_karupan']);
Route::POST('/karupan/destroy', [KarupanController::class, 'destroy'])->name('destroykarupan');
Route::get('delete/{asset_id}', [KarupanController::class, 'delete'])->name('delete');
Route::get('/edit_karupan', [AssetController::class, 'edit']);
Route::post('/update_karupan', [AssetController::class, 'update']);
Route::get('/asset/detail/{id}', [KarupanController::class, 'show'])->name('assetdetail');
Route::get('/search', [KarupanController::class, 'search'])->name('searchasset');
Route::get('/', [KarupanController::class, 'index'])->name('index');

// หน้าแสดงผลต่าง ๆ
Route::get('/text{name}', function ($text) {
    return "ปี ${text}";
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/repair/repairmain', [RepairController::class, 'dashboard'])->name('repairmain');

// รายการแจ้งซ่อม
Route::get('/repair/repairlist', [RepairController::class, 'index'])->name('repairlist');
Route::put('/update-repair-status/{repairId}', [RepairController::class, 'updateRepairStatus'])->name('updateRepairStatus');
Route::get('/repair/repairprogress', [RepairController::class, 'progress'])->name('repairprogress');
Route::get('/repair/repairdone', [RepairController::class, 'done'])->name('repairdone');
Route::get('/repair/repaircancel', [RepairController::class, 'cancle'])->name('repaircancel');
Route::get('/repair/searchrepair', [RepairController::class, 'search'])->name('searchrepair');

// หน้าเบิก
Route::get('/borrow/borrowmain', function () {
    return view('borrowmain');
})->name('borrowmain');
Route::get('/layoutmenu', function () {
    return view('layoutmenu');
});

// แจ้งซ่อม
Route::get('/repair/requestrepair', [RepairController::class, 'showAddForm'])->name('requestrepair');
Route::post('/repair/requestrepair/store-repair-request', [RepairController::class, 'storeRepairRequest'])->name('addrequestrepair');
Route::get('/search-assets', [RepairController::class, 'searchAssets'])->name('search.assets');

// ยื่นคำร้องยืมครุภัณฑ์
// Route สำหรับแสดงฟอร์มการยืมครุภัณฑ์
Route::get('/storeborrowrequest', [BorrowRequestController::class, 'index'])->name('storeborrowrequest');

// Route สำหรับบันทึกข้อมูลการยืมครุภัณฑ์
Route::post('/storeborrowrequest', [BorrowRequestController::class, 'storeborrowrequest'])->name('storeborrowrequest.store');

// Route สำหรับแสดงรายการการยืมครุภัณฑ์
Route::get('/borrowlist', [BorrowRequestController::class, 'borrowList'])->name('borrowlist');

// Route สำหรับหน้าประวัติการยืม
Route::get('/borrowhistory', [BorrowRequestController::class, 'borrowHistory'])->name('borrowhistory');

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
