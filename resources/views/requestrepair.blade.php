@extends('layoutmenu')

@section('title', 'แจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <!-- เพิ่มฟอร์มตรงนี้ -->
    <form action="{{ route('addrequestrepair') }}" method="POST">
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
                <label for="symptom_detail" class="form-label">รายละเอียดอาการเสีย:</label>
                <input type="text" class="form-control" id="symptom_detail" name="symptom_detail">
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">สถานที่:</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-success">ยืนยัน</button>
        </div>
    </form>
    <!-- จบฟอร์ม -->
@endsection
