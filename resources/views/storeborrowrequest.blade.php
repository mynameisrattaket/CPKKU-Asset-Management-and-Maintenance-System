@extends('layoutmenu')

@section('title', 'ยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title fw-bold">📌 แบบฟอร์มการยืมครุภัณฑ์</h4>
@endsection

@section('conten')

<!-- ✅ ฟอร์มยืมครุภัณฑ์ -->
<div class="card shadow border-0 p-4">
    <h5 class="fw-bold text-dark mb-3">กรอกข้อมูลการยืมครุภัณฑ์</h5>

    <!-- แสดงข้อความแจ้งเตือน -->
    @if (Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('storeborrowrequest.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- เลือกครุภัณฑ์ -->
            <div class="col-md-6 mb-3">
                <label for="asset_id" class="form-label fw-bold">📌 หมายเลขครุภัณฑ์:</label>
                <select class="form-select" id="asset_id" name="asset_id" required>
                    <option value="">-- เลือกครุภัณฑ์ --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->asset_id }}">{{ $asset->asset_name }} ({{ $asset->asset_number }})</option>
                    @endforeach
                </select>
            </div>

            <!-- ชื่อผู้ยืม -->
            <div class="col-md-6 mb-3">
                <label for="borrower_name" class="form-label fw-bold">👤 ชื่อ-นามสกุล:</label>
                <input type="text" class="form-control" id="borrower_name" name="borrower_name" placeholder="กรอกชื่อ-นามสกุล" required>
            </div>
        </div>

        <div class="row">
            <!-- วันที่ยืม -->
            <div class="col-md-6 mb-3">
                <label for="borrow_date" class="form-label fw-bold">📅 วันที่ยืม:</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
            </div>

            <!-- วันที่คืน -->
            <div class="col-md-6 mb-3">
                <label for="return_date" class="form-label fw-bold">📆 วันที่คืน:</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
        </div>

        <div class="row">
            <!-- สถานที่ยืม -->
        <div class="col-md-6 mb-3">
            <label for="location" class="form-label fw-bold">📍 สถานที่ยืม:</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="กรอกสถานที่ยืม" required>
        </div>

        <!-- หมายเหตุเพิ่มเติม -->
        <div class="col-md-6 mb-3">
            <label for="note" class="form-label fw-bold">📝 หมายเหตุเพิ่มเติม:</label>
            <textarea class="form-control" id="note" name="note" rows="2" placeholder="ระบุหมายเหตุเพิ่มเติม (ถ้ามี)"></textarea>
        </div>


        <!-- สถานะ (hidden field) -->
        <input type="hidden" name="status" value="pending"> <!-- ✅ ค่าเริ่มต้นเป็นรอดำเนินการ -->

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-lg btn-success shadow">✅ ยืนยันการยืม</button>
        </div>
    </form>
</div>

@endsection

<!-- ✅ แจ้งเตือนบันทึกสำเร็จ -->
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // แสดงข้อความแจ้งเตือนถ้ามี
        @if(session('success'))
            showAlert("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showAlert("{{ session('error') }}", 'danger');
        @endif
    });

    // ฟังก์ชันแสดงข้อความแจ้งเตือน
    function showAlert(message, type) {
        const alertContainer = document.getElementById('alert-container');
        const alertElement = document.createElement('div');
        alertElement.className = `alert alert-${type} alert-dismissible fade show`;
        alertElement.role = 'alert';
        alertElement.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        alertContainer.appendChild(alertElement);

        // ลบข้อความแจ้งเตือนหลัง 5 วินาที
        setTimeout(() => {
            alertElement.remove();
        }, 5000);
    }
</script>
@endsection
