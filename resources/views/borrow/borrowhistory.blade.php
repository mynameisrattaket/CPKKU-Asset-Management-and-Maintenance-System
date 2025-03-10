@extends('layoutmenu')

@section('title', 'ประวัติการยืมครุภัณฑ์')

@section('contentitle')
    <h1 class="page-title text-center fw-bold">ประวัติการยืมครุภัณฑ์</h1>
@endsection
<style>

    .table-responsive {
    max-width: 100%;
    width: 100%;
    overflow-x: auto;
}

table#borrowTable {
    width: 100%; /* ทำให้ตารางขยายเต็มพื้นที่ */
    font-size: 2x; /* เพิ่มขนาดตัวอักษร */
    table-layout: auto; /* ปรับให้คอลัมน์ขยายตามเนื้อหา */
    
}
.table-dark.text-center th {  /* ปรับหัวตารางข้อมูล*/
    text-align: center;
    white-space: nowrap;  
}
th, td {
    padding: 20px; /* เพิ่มระยะห่างของเซลล์ให้ใหญ่ขึ้น */
    white-space: nowrap; /* ป้องกันข้อความขึ้นบรรทัดใหม่ */
    text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
}
.card {
    margin-top: -10px; /* ลดระยะห่างของฟอร์ม */
    padding-top: 15px; /* ปรับให้พอดี */
}
.status-badge {
    padding: 8px 15px !important;
    font-weight: bold !important;
    border-radius: 50px !important;
    display: inline-block !important;
    min-width: 100px !important;
    text-align: center !important;
    font-size: 14px !important;
}

/* ✅ รอดำเนินการ (สีเหลือง) */
.status-pending {
    background-color:rgb(239, 201, 96) !important;
    color: #000 !important;
}

/* ✅ ได้รับอนุมัติ (สีเขียว) */
.status-approved {
    background-color:rgb(0, 155, 75) !important;
    color: #fff !important;
}

/* ✅ ถูกปฏิเสธ (สีแดง) */
.status-rejected {
    background-color:rgb(152, 0, 0) !important;
    color: #fff !important;
}

/* ✅ คืนแล้ว (สีฟ้า) */
.status-completed {
    background-color:rgb(0, 107, 139) !important;
    color: #fff !important;
}


</style>

@section('conten')

<div class="container mt-3">
    <!-- 🔍 ฟอร์มสำหรับค้นหา -->
    <div class="card shadow-sm border-0 p-4">
        <form id="searchForm" action="{{ route('borrowhistory') }}" method="GET">
            <div class="row g-2">
                <!-- ค้นหาครุภัณฑ์ -->
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white">🔍</span>
                        <input type="text" class="form-control shadow-sm" placeholder="ค้นหาครุภัณฑ์ (ชื่อ/หมายเลข)" name="searchasset" value="{{ request('searchasset') }}">
                    </div>
                </div>
                <!-- ชื่อ-นามสกุล -->
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white">👤</span>
                        <input type="text" class="form-control shadow-sm" placeholder="ชื่อ-นามสกุล" name="borrower_name" value="{{ request('borrower_name') }}">
                    </div>
                </div>
                <!-- ปุ่มค้นหา -->
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary fw-bold shadow-sm">🔎 ค้นหา</button>
                </div>
            </div>

            <div class="row g-2 mt-3">
                <!-- วันที่ยืม -->
                <div class="col-md-5">
                    <label class="form-label fw-bold">📅 วันที่ยืม</label>
                    <div class="input-group">
                        <input type="date" class="form-control shadow-sm" name="borrow_date" value="{{ request('borrow_date') }}">
                    </div>
                </div>
                <!-- วันที่คืน -->
                <div class="col-md-5">
                    <label class="form-label fw-bold">📅 วันที่คืน</label>
                    <div class="input-group">
                        <input type="date" class="form-control shadow-sm" name="return_date" value="{{ request('return_date') }}">
                    </div>
                </div>
                <!-- ปุ่มเคลียร์ -->
                <div class="col-md-2 d-grid align-items-end">
                    <a href="{{ route('borrowhistory') }}" class="btn btn-secondary fw-bold shadow-sm">♻️ เคลียร์</a>
                </div>
            </div>
        </form>
    </div>
</div>


    <!-- ✅ ตารางแสดงผล -->
    <div class="table-responsive mt-0 shadow-sm">
    <table id="borrowTable" class="table table-hover table-bordered align-middle table-lg w-100">
            <thead class="table-dark text-center">
                <tr>
                    <th>ไอดี</th>
                    <th>หมายเลขครุภัณฑ์</th>
                    <th>ชื่อครุภัณฑ์</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>วันที่ยืม</th>
                    <th>วันที่คืน</th>
                    <th>สถานะ</th> <!-- ✅ เพิ่มคอลัมน์สถานะ -->
                </tr>
            </thead>
            <tbody>
                    @if($borrowRequests->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center text-muted fw-bold">❌ ไม่พบข้อมูล</td>
                        </tr>
                    @else
                        @foreach($borrowRequests as $request)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->asset->asset_number ?? '-' }}</td>
                            <td>{{ $request->asset->asset_name ?? '-' }}</td>
                            <td>{{ $request->borrower_name }}</td>
                            <td>{{ $request->borrow_date ? \Carbon\Carbon::parse($request->borrow_date)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="status-badge 
                                    {{ $request->status == 'pending' ? 'status-pending' : '' }}
                                    {{ $request->status == 'approved' ? 'status-approved' : '' }}
                                    {{ $request->status == 'rejected' ? 'status-rejected' : '' }}
                                    {{ $request->status == 'completed' ? 'status-completed' : '' }}">
                                    {{ $request->status == 'pending' ? 'รออนุมัติ' : '' }}
                                    {{ $request->status == 'approved' ? 'ได้รับอนุมัติ' : '' }}
                                    {{ $request->status == 'rejected' ? 'ถูกปฏิเสธ' : '' }}
                                    {{ $request->status == 'completed' ? 'คืนแล้ว' : '' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>

        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#borrowTable').DataTable({
            responsive: true,
            autoWidth: false,
            searching: true, // ✅ เปิดค้นหา
            order: [[0, 'asc']], // ✅ เรียงลำดับตาม ID (ไอดี 1 มาก่อน)
            language: {
                search: "🔍ค้นหา: ",
                searchPlaceholder: "ค้นหาข้อมูล...",
                lengthMenu: "แสดง _MENU_ รายการ",
                info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                zeroRecords: "❌ ไม่พบข้อมูล",
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ถัดไป",
                    previous: "ก่อนหน้า"
                }
            }
        });
    });
</script>
@endsection