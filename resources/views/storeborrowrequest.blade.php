@extends('layoutmenu')

@section('title', 'ยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการแจ้งซ่อม</h4>
@endsection

@section('conten') <!-- ใช้ชื่อให้ตรงกับ layoutmenu.blade.php -->
<div class="mt-3">
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

    <!-- ฟอร์มยืมครุภัณฑ์ -->
    <form action="{{ route('storeborrowrequest.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="asset_id" class="form-label">หมายเลขอุปกรณ์:</label>
                <select class="form-select" id="asset_id" name="asset_id" required>
                    <option value="">-- เลือกครุภัณฑ์ --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->asset_id }}">{{ $asset->asset_name }} ({{ $asset->asset_number }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="borrower_name" class="form-label">ชื่อ-นามสกุล:</label>
                <input type="text" class="form-control" id="borrower_name" name="borrower_name" placeholder="กรอกชื่อ-นามสกุล" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="borrow_date" class="form-label">วันที่ยืม:</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="return_date" class="form-label">วันที่คืน:</label>
                <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-success">ยืนยัน</button>
        </div>
    </form>
</div>
@endsection


<!-- แจ้งเตือนบันทึกสำเร็จ -->
    <div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>


    <!-- /End-bar -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script src="https://cpkku-durablearticles.drnadech.com/./assets/js/vendor.min.js"></script>
    <script src="https://cpkku-durablearticles.drnadech.com/./assets/js/app.min.js"></script>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- jsแจ้งเตือนบันทึกสำเร็จ -->
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

    // ฟังก์ชันสำหรับแสดงข้อความแจ้งเตือน
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

        // ลบข้อความแจ้งเตือนอัตโนมัติหลังจาก 5 วินาที
        setTimeout(() => {
            alertElement.remove();
        }, 5000);
    }
</script>

    <script>
        let table = new DataTable('#basic-datatable', {
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'ทั้งหมด']
            ]
        });
    </script>
 
</body>

</html>


