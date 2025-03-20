@extends('layoutmenu')

@section('title', 'ประวัติการยืมครุภัณฑ์')

@section('contentitle')
    <h1 class="page-title text-center fw-bold">ประวัติการยืมครุภัณฑ์</h1>
@endsection
<style>
/* ✅ ปรับ container หลัก */
.container {
    width: 100%;  /* ขยายให้เต็มขนาดหน้าจอ */
    max-width: 100%; /* ให้เต็มขนาด */
    margin: 0 auto;
    max-height: 550px; /* กำหนดความสูงของตาราง */
    overflow-y: auto; /* เพิ่มการเลื่อนในแนวตั้ง */
    
}
/* ✅ ทำให้ตารางสามารถย่อขนาดได้ */
.table-responsive {
    width: 100%;
    overflow-x: auto; /* เลื่อนในแนวนอนเมื่อจอเล็กลง */
    white-space: nowrap;
    padding: 0px;
    
}
.table-dark.text-center th {
   padding-right: 26px !important;
}

/* ✅ ปรับขนาดตารางให้พอดีกับหน้าจอ */
#borrowTable {
    width: 100%;
    margin: auto;
    font-size: 13px; /* ลดขนาดตัวอักษร */
    table-layout: auto; /* ทำให้ตารางขยายตามเนื้อหา */
    word-wrap: break-word;
}
/* ✅ ปรับการจัดการหัวตาราง */
table thead {
    background-color: #343a40; /* สีพื้นหลังของหัวตาราง */
    color: #ffffff; /* สีของตัวอักษร */

}

/* ✅ ปรับขนาดคอลัมน์เพื่อให้พอดีจอ */
#borrowTable th, #borrowTable td {
    padding: 10px; /* เพิ่ม padding */
    text-align: center;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ✅ ปรับขนาดแต่ละคอลัมน์ */
/* เพิ่มความกว้างให้คอลัมน์ในตาราง */
#borrowTable th:nth-child(1), #borrowTable td:nth-child(1) {
    width: 8%; /* ไอดี */
}

#borrowTable th:nth-child(2), #borrowTable td:nth-child(2) {
    width: 18%; /* หมายเลขครุภัณฑ์ */
}

#borrowTable th:nth-child(3), #borrowTable td:nth-child(3) {
    width: 18%; /* ชื่อครุภัณฑ์ */
}

#borrowTable th:nth-child(4), #borrowTable td:nth-child(4) {
    width: 15%; /* ชื่อ-นามสกุล */
}

#borrowTable th:nth-child(5), #borrowTable td:nth-child(5) {
    width: 12%; /* สถานที่ยืม */
}

#borrowTable th:nth-child(6), #borrowTable td:nth-child(6),
#borrowTable th:nth-child(7), #borrowTable td:nth-child(7) {
    width: 12%; /* วันที่ยืม & วันที่คืน */
}

#borrowTable th:nth-child(9), #borrowTable td:nth-child(9) {
    width: 20%; /* สถานะ */
}

/* ปรับขนาดคอลัมน์ View */
#borrowTable th:nth-child(10), #borrowTable td:nth-child(10) {
    width: 10%; /* ปรับความกว้างคอลัมน์ View */
  
}
/* ✅ ปรับขนาดป้ายสถานะ */
.status-badge {
    display: inline-block;
    padding: 6px 8px !important;
    font-size: 12px !important;
    font-weight: bold !important;
    border-radius: 4px !important;
    min-width: 90px;
    max-width: 100px;
    white-space: nowrap;
}

/* ✅ ปรับขนาดปุ่ม View */
.view-borrow {
    border: none !important; /* เอาขอบออก */
    outline: none !important; /* เอาขอบเบาๆออก */
    background-color: transparent !important; /* เอาพื้นหลังออก */
    font-size: 16px; /* ขนาดตัวอักษร */
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center; /* จัดให้อยู่กลางในแนวตั้ง */
    justify-content: center; /* จัดให้อยู่กลางในแนวนอน */
}

/* ✅ ป้องกันตารางล้นหน้าจอขนาดเล็ก */
@media (max-width: 1600px) {
    #borrowTable {
        font-size: 12px; /* ลดขนาดตัวอักษรในหน้าจอเล็ก */
    }

    .status-badge {
        min-width: 80px;
        font-size: 11px;
        padding: 5px;
    }

    .view-borrow {
        width: 30px;
        height: 30px;
        font-size: 14px;
    }
}

@media (max-width: 768px) {
    /* สำหรับมือถือหรือจอขนาดเล็ก */
    #borrowTable th, #borrowTable td {
        padding: 6px; /* ลดขนาด padding ในจอเล็ก */
        font-size: 11px; /* ลดขนาดตัวอักษร */
    }

    /* ปรับให้ตารางสามารถเลื่อนในแนวนอนได้ */
    .table-responsive {
        overflow-x: scroll;
        -webkit-overflow-scrolling: touch;
    }

    .view-borrow {
        width: 30px;
        height: 30px;
        font-size: 14px;
    }
}

/* ✅ รอดำเนินการ (สีเหลือง) */
.status-pending {
    background-color:rgb(216, 210, 34) !important;
    color: #000 !important;
}

/* ✅ ได้รับอนุมัติ (สีเขียว) */
.status-approved {
    background-color:rgb(30, 120, 76) !important;
    color: #fff !important;
}

/* ✅ ถูกปฏิเสธ (สีแดง) */
.status-rejected {
    background-color:rgb(204, 4, 4) !important;
    color: #fff !important;
}

/* ✅ คืนแล้ว (สีฟ้า) */
.status-completed {
    background-color:rgb(17, 59, 122) !important;
    color: #fff !important;
}

</style>

@section('conten')

<div class="container mt-0">
        <!-- 🔍 ฟอร์มสำหรับค้นหา -->
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

            <div class="row g-2 mt-1">
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

        <!-- ✅ ตารางแสดงผล -->
        <div class="table-responsive mt-0 ">
            <table id="borrowTable" class="table table-hover table-bordered align-middle table-lg w-100">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ไอดี</th>
                        <th>หมายเลขครุภัณฑ์</th>
                        <th>ชื่อครุภัณฑ์</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>สถานที่ยืม</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่คืน</th>
                        <th>สถานะ</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @if($borrowRequests->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-muted fw-bold">❌ ไม่พบข้อมูล</td>
                        </tr>
                    @else
                        @foreach($borrowRequests as $request)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->asset->asset_number ?? '-' }}</td>
                            <td>{{ $request->asset->asset_name ?? '-' }}</td>
                            <td>{{ $request->borrower_name }}</td>
                            <td>{{ $request->location ?? '-' }}</td>
                            <td>{{ $request->borrow_date ? \Carbon\Carbon::parse($request->borrow_date)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('d/m/Y') : '-' }}</td> 
                            <td>
                                <span class="status-badge 
                                    {{ $request->status == 'pending' ? 'status-pending' : '' }}
                                    {{ $request->status == 'approved' ? 'status-approved' : '' }}
                                    {{ $request->status == 'rejected' ? 'status-rejected' : '' }}
                                    {{ $request->status == 'completed' ? 'status-completed' : '' }}">
                                    {{ $request->status == 'pending' ? 'รอดำเนินการ' : '' }}
                                    {{ $request->status == 'approved' ? 'ได้รับอนุมัติ' : '' }}
                                    {{ $request->status == 'rejected' ? 'ถูกปฏิเสธ' : '' }}
                                    {{ $request->status == 'completed' ? 'คืนแล้ว' : '' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-outline-secondary btn-sm view-borrow" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#borrowDetailModal"
                                    data-id="{{ $request->id }}"
                                    data-asset="{{ $request->asset->asset_name ?? '-' }}"
                                    data-asset-number="{{ $request->asset->asset_number ?? '-' }}"
                                    data-borrower="{{ $request->borrower_name }}"
                                    data-location="{{ $request->location ?? '-' }}"
                                    data-borrow-date="{{ $request->borrow_date ? \Carbon\Carbon::parse($request->borrow_date)->format('d/m/Y') : '-' }}"
                                    data-return-date="{{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('d/m/Y') : '-' }}"
                                    data-status="{{ ucfirst($request->status) }}"
                                    data-note="{{ $request->note ?? '-' }}">
                                    👁
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    
</div>


<!-- ✅ Modal สำหรับดูรายละเอียด -->
<div class="modal fade" id="borrowDetailModal" tabindex="-1" aria-labelledby="borrowDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">  <!-- 🔥 เพิ่มขนาดเป็น extra-large -->
        <div class="modal-content border-0 shadow-lg">  <!-- 🚀 เอาเส้นขอบออก & เพิ่มเงา -->
            <div class="modal-header bg-Primary text-white">
                <h5 class="modal-title fw-bold">📋 รายละเอียดการยืมครุภัณฑ์</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="container">
                    <div class="row">
                        <!-- 🔹 คอลัมน์ซ้าย -->
                        <div class="col-md-6 mb-3">
                            <p class="mb-2"><strong>📌 ชื่อครุภัณฑ์:</strong> <span id="modalAsset"></span></p>
                            <p class="mb-2"><strong>🔢 หมายเลขครุภัณฑ์:</strong> <span id="modalAssetNumber"></span></p>
                            <p class="mb-2"><strong>👤 ผู้ยืม:</strong> <span id="modalBorrower"></span></p>
                            <p class="mb-2"><strong>📍 สถานที่ยืม:</strong> <span id="modalLocation"></span></p>
                        </div>
                        <!-- 🔹 คอลัมน์ขวา -->
                        <div class="col-md-6 mb-3">
                            <p class="mb-2"><strong>📅 วันที่ยืม:</strong> <span id="modalBorrowDate"></span></p>
                            <p class="mb-2"><strong>📅 วันที่คืน:</strong> <span id="modalReturnDate"></span></p>
                            <p class="mb-2"><strong>⭐ สถานะ:</strong> <span id="modalStatus"></span></p>
                            <p class="mb-2"><strong>📝 หมายเหตุ:</strong> <span id="modalNote"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">  <!-- ❌ เอาเส้นขอบออก -->
                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
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

        // ✅ ฟังก์ชันตรวจสอบข้อมูลเมื่อกรอง
    function checkNoData() {
        let rowCount = table.rows({ filter: 'applied' }).data().length;
        if (rowCount === 0) {
            $('#borrowTable tbody').html(`
                <tr>
                    <td colspan="10" class="text-center text-muted fw-bold">❌ ไม่พบข้อมูล</td>
                </tr>
            `);
        }
    }

    // ✅ ตรวจสอบการเปลี่ยนแปลงค่าของฟอร์มวันที่
    $('input[name="borrow_date"], input[name="return_date"]').on('change', function() {
        let borrowDate = $('input[name="borrow_date"]').val();
        let returnDate = $('input[name="return_date"]').val();

        // ✅ ฟอร์แมตวันที่เป็น d/m/Y
        function formatDate(date) {
            if (!date) return "";
            let parts = date.split("-");
            return parts[2] + "/" + parts[1] + "/" + parts[0]; // เปลี่ยนเป็น dd/mm/yyyy
        }

        let formattedBorrowDate = formatDate(borrowDate);
        let formattedReturnDate = formatDate(returnDate);

        // ✅ กรองข้อมูลจาก DataTable
        table.columns(5).search(formattedBorrowDate).columns(6).search(formattedReturnDate).draw();

        // ✅ ตรวจสอบข้อมูลและแสดง "❌ ไม่พบข้อมูล" ถ้าไม่มี
        checkNoData();
    });
    });

</script>
<script>
    $(document).ready(function() {
    // รีเฟรชข้อมูลทุกครั้งที่หน้าโหลดใหม่
    function updateModalData() {
        $('.view-borrow').on('click', function() {
            // ดึงข้อมูลจาก data-* attributes ของปุ่ม
            let asset = $(this).data('asset');
            let assetNumber = $(this).data('asset-number');
            let borrower = $(this).data('borrower');
            let location = $(this).data('location');
            let borrowDate = $(this).data('borrow-date');
            let returnDate = $(this).data('return-date');
            let status = $(this).data('status');
            let note = $(this).data('note');

            // แสดงข้อมูลใน modal
            $('#modalAsset').text(asset);
            $('#modalAssetNumber').text(assetNumber);
            $('#modalBorrower').text(borrower);
            $('#modalLocation').text(location);
            $('#modalBorrowDate').text(borrowDate);
            $('#modalReturnDate').text(returnDate);
            $('#modalStatus').text(status);
            $('#modalNote').text(note);

            // เปิด modal
            $('#borrowDetailModal').modal('show');
        });
    }

    // อัปเดตข้อมูลใน modal หลังจากหน้าโหลดใหม่
    updateModalData();

    // หากข้อมูลใน table มีการเปลี่ยนแปลงหรือรีเฟรชอีกครั้ง
    $('#borrowTable').on('draw.dt', function() {
        updateModalData();
    });
});


</script>

@endsection