@extends('layoutmenu')

@section('title', 'ยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
    <!-- เพิ่มฟอร์มตรงนี้ -->
    <form action="{{ route('storeborrowrequest') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="asset_number" class="form-label">หมายเลขอุปกรณ์:</label>
                <input type="text" class="form-control" id="asset_number" name="asset_number">
            </div>
            <div class="mb-3">
                <label for="asset_name" class="form-label">ชื่ออุปกรณ์:</label>
                <input type="text" class="form-control" id="asset_name" name="asset_name">
            </div>
            <div class="mb-3">
                <label for="borrower_name" class="form-label">ชื่อผู้ยืม:</label>
                <input type="text" class="form-control" id="borrower_name" name="borrower_name">
            </div>
            <div class="mb-3">
                <label for="borrower_surname" class="form-label">นามสกุลผู้ยืม:</label>
                <input type="text" class="form-control" id="borrower_surname" name="borrower_surname">
            </div>
            <div class="mb-3">
                <label for="return_date" class="form-label">วันที่ต้องการคืน:</label>
                <input type="date" class="form-control" id="return_date" name="return_date">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-success">ยืนยัน</button>
        </div>
    </form>
    <!-- จบฟอร์ม -->
@endsection
