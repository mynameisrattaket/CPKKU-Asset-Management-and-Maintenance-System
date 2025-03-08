@extends('layoutmenu')

@section('title', 'แก้ไขคำร้องขอยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title fw-bold">✏️ แก้ไขคำร้องขอยืมครุภัณฑ์</h4>
@endsection

@section('conten')

<div class="card shadow border-0 p-4">
    <h5 class="fw-bold text-dark mb-3">🔍 แก้ไขข้อมูลคำร้อง</h5>

    <!-- ✅ ตรวจสอบ Action และ Method -->
    <form action="{{ route('borrow.update', $borrow->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">👤 ชื่อผู้ยืม:</label>
                <input type="text" class="form-control" name="borrower_name" value="{{ old('borrower_name', $borrow->borrower_name) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">📅 วันที่ยืม:</label>
                <input type="date" class="form-control" name="borrow_date" value="{{ old('borrow_date', $borrow->borrow_date) }}" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">📅 วันที่คืน:</label>
                <input type="date" class="form-control" name="return_date" value="{{ old('return_date', $borrow->return_date) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">📌 สถานะ:</label>
                <select class="form-select" name="status" required>
                    <option value="pending" {{ $borrow->status == 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                    <option value="approved" {{ $borrow->status == 'approved' ? 'selected' : '' }}>✅ อนุมัติ</option>
                    <option value="completed" {{ $borrow->status == 'completed' ? 'selected' : '' }}>📦 คืนแล้ว</option>
                    <option value="rejected" {{ $borrow->status == 'rejected' ? 'selected' : '' }}>❌ ถูกปฏิเสธ</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-lg btn-primary">💾 บันทึกการแก้ไข</button>
        </div>
    </form>
</div>

@endsection

