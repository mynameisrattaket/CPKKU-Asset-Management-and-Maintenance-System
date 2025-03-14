@extends('layoutmenu')

@section('title', 'รายการคำร้องขอยืมครุภัณฑ์')

<style>
/* ตารางข้อมูล */
.table-dark.text-center th {  /* ปรับหัวตารางข้อมูล */
    background-color: rgb(30, 44, 59);
    color: #ffffff;
    text-align: center;
    font-size: 15px !important;  /* ลดขนาดฟอนต์ให้เล็กสุด */
    white-space: nowrap;  
    padding-top: 10px !important;  /* ลด Padding */
    padding-bottom: 10px !important;  /* ลด Padding */
}

#borrowTable {  /* กำหนดค่าพื้นฐานให้กับตาราง */
    text-align: center;
    border-collapse: collapse;  /* ทำให้เส้นขอบติดกัน */
    width: 100%;
    margin: auto;  /* จัดให้ตารางอยู่ตรงกลาง */
    font-size: 9px;  /* ลดขนาดฟอนต์ให้เล็กสุด */
}

#borrowTable th, #borrowTable td {  /* ปรับสไตล์ให้กับหัวตาราง (<th>) และเซลล์ข้อมูล (<td>) */
    text-align: center;
    border-right: 0.5px solid rgb(35, 57, 77); 
}

/* เซลข้อมูล */
#borrowTable tbody td {
    font-size: 13px!important;  
    border-right: 1px solid rgba(214, 214, 214, 0.2); /* เพิ่มแถบเส้นกั้นระหว่างคอลัมน์ */
    border-left: 1px solid rgba(214, 214, 214, 0.2);
    border-bottom: 1px solid rgba(214, 214, 214, 0.2);  /* เส้นขอบสีเทาอ่อน */
    padding-top: 5px !important;  /* ลด Padding */
    padding-bottom: 5px !important;  /* ลด Padding */
    white-space: normal;  /* ให้ข้อความตัดบรรทัดใหม่ */
    word-wrap: break-word;  /* ให้ข้อความยาวเกินไปตัดบรรทัดใหม่ */
    word-break: break-word;  /* ให้ข้อความยาวเกินไปตัดบรรทัดใหม่ */
}


#borrowTable tbody tr:nth-child(odd) {
    background-color: rgb(248, 248, 248) !important; /* แถวคี่ */
    color: rgb(0, 5, 9);
}

#borrowTable tbody tr:nth-child(even) {
    background-color: #ffffff !important; /* แถวคู่ */
    color: rgb(3, 17, 29);
}

/* ปรับขนาดป้ายสถานะ */
#borrowTable .status-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2px !important;  /* เพิ่ม Padding เพื่อให้ป้ายกว้างขึ้น */
    font-size: 12px !important;  /* ขนาดฟอนต์ที่เหมาะสม */
    font-weight: bold !important;
    border-radius: 12px !important;  /* รูปทรงป้ายสถานะให้มนและขนาดใหญ่ขึ้น */
    text-align: center;
    width: auto;  /* ปรับความกว้างให้ยืดตามข้อความ */
    height: 40px;  /* เพิ่มความสูงของป้าย */
    transition: all 0.3s ease-in-out;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1); /* เพิ่มขนาดเงา */
    border: 1px solid rgba(0, 0, 0, 0.3) !important; /* เพิ่มขอบ */
    cursor: default;
}


/* ปรับขนาดและรูปทรงของปุ่มใน dropdown */
#borrowTable .btn-group .btn {
    font-size: 10px !important;  /* ขนาดฟอนต์เล็กลงให้เหมาะสม */
    padding: 5px  !important;  /* ปรับ Padding ให้พอดีกับปุ่ม */
    width: 100% !important;  /* ให้ปุ่มมีความกว้างเต็มคอลัมน์ */
    height: 35px !important;  /* เพิ่มความสูงของปุ่มให้พอดีกับคอลัมน์ */
    border-radius: 8px !important;  /* ให้ขอบของปุ่มมน */
    text-align: center;
    display: flex;
    align-items: center;  /* จัดให้ข้อความอยู่กลาง */
    justify-content: center;  /* จัดให้ข้อความอยู่กลาง */
    align-items: center;  /* จัดให้ปุ่มอยู่กึ่งกลางในแนวตั้ง */
}
/* ปรับสไตล์ของเมนู dropdown */
.dropdown-menu {
    padding: 5px  !important;
    background-color:rgb(40, 40, 1)!important;
    width: auto !important;
    min-width: 90px !important;
   
}

/* ปรับขนาดของปุ่มในเมนู dropdown สำหรับ "อนุมัติ" */
#borrowTable .dropdown-item.text-success {
    font-size: 9px !important;
    padding: 4px 8px !important;
    text-align: center;
    border-radius: 6px !important;
    height: 30px !important;
}

/* ปรับขนาดของปุ่มในเมนู dropdown สำหรับ "ปฏิเสธ" */
#borrowTable .dropdown-item.text-danger {
    font-size: 9px !important;
    padding: 4px 8px !important;
    text-align: center;
    border-radius: 6px !important;
    height: 30px !important;
}

/* ปรับขนาดของปุ่มในเมนู dropdown สำหรับ "คืนแล้ว" */
#borrowTable .dropdown-item.text-primary {
     font-size: 9px !important;
    padding: 4px 8px !important;
    text-align: center;
    border-radius: 6px !important;
    height: 30px !important;
}

/* ปุ่มลบคำร้อง */
/* ปรับสีพื้นหลังของเมนู dropdown สำหรับ "ลบคำร้อง" */
#borrowTable .dropdown-menu.delete-menu {
    background-color: rgb(255, 255, 255) !important;  /* เปลี่ยนสีพื้นหลังเป็นสีเหลือง */
    min-width: 50px !important;  /* กำหนดความกว้างขั้นต่ำ */
    padding: 5px !important;
    width: auto !important;  /* ขนาดเมนูปรับตามเนื้อหา */
    position: relative;
}

/* ปรับปุ่ม "ลบคำร้อง" */
.delete-btn {
    font-size: 9px !important;
    padding: 4px 8px !important;
    text-align: center;
    border-radius: 6px !important;
    height: 30px !important;
}


/* สถานะต่าง ๆ */
#borrowTable .status-pending {
    background: linear-gradient(135deg, #FFC107, #FFB300) !important;
    color: #000 !important;
    border-color: #E6A700 !important;
}

#borrowTable .status-approved {
    background: linear-gradient(135deg, #00C853, #009624) !important;
    color: #fff !important;
    border-color: #008000 !important;
}

#borrowTable .status-rejected {
    background: linear-gradient(135deg, #D50000, #FF1744) !important;
    color: #fff !important;
    border-color: #FF1744 !important;
}

#borrowTable .status-completed {
    background: linear-gradient(135deg, #2962FF, #1E88E5) !important;
    color: #fff !important;
    border-color: #1E88E5 !important;
}

#borrowTable .status-secondary {
    background: linear-gradient(135deg, #9E9E9E, #BDBDBD) !important;
    color: #fff !important;
    border-color: #757575 !important;
}


/* ปรับขนาดการ์ดสรุปผลข้อมูล */
.status-card h5 {
    font-size: 1rem !important;  /* ลดขนาดหัวข้อ */
}

.status-card h2 {
    font-size: 1rem !important;  /* ลดขนาดตัวเลข */
}

.status-card span {
    font-size: 0.7rem !important;  /* ลดขนาดข้อความอัปเดต */
}

/* การ์ด */
.status-card {
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* ลดขนาดเงา */
    font-size: 0.9rem;
}

.status-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.status-card .card-body {
    position: relative;
    z-index: 2;
}

.status-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

/* สีพื้นหลังแบบ Gradient */
.status-pending { background: linear-gradient(135deg,rgb(250, 250, 238),rgb(244, 243, 232)); }
.status-rejected { background: linear-gradient(135deg,rgb(247, 242, 242),rgb(248, 229, 238)); }
.status-approved { background: linear-gradient(135deg,rgb(241, 250, 241),rgb(205, 231, 231)); }
.status-completed { background: linear-gradient(135deg,rgb(248, 245, 252),rgb(233, 232, 252)); }

/* ไอคอนแบบโปร่งแสง */
.status-card i {
    font-size: 50px;  /* ลดขนาดไอคอน */
    position: absolute;
    right: 10px;
    top: 10px;
    opacity: 0.15;
}

/* ปรับขนาดและสีของตัวเลขสถิติ */
.status-card .stat-number {
    font-size: 1.5rem !important;  /* ลดขนาดตัวเลข */
    font-weight: bold !important;
    color: rgb(11, 2, 26) !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

/* ปรับสีของ "อัปเดตล่าสุด" */
.status-card .last-update {
    font-size: 0.7rem !important;  /* ขนาดเล็กลง */
    font-weight: bold !important;
    color: #259b24 !important;
}

/* ปรับขนาดของแถวในตารางให้เหมาะสมกับหน้าจอ */
.row {
    background-color: rgb(252, 252, 252);
    display: flex;
    flex-wrap: wrap;  /* ทำให้แถวสามารถขึ้นบรรทัดใหม่ได้เมื่อหน้าจอเล็ก */
}

</style>


@section('contentitle')
    <h4 class="page-title #212121" style="font-size: 1.2 rem;">รายการคำร้องขอยืมครุภัณฑ์ </h4>
@endsection


@section('conten')

<div class="row">
    @php
        $statuses = [
            ['title' => 'รอดำเนินการ', 'count' => $countPending, 'class' => 'status-pending', 'icon' => 'uil-clock', 'last_update' => $lastUpdatePending ?? ' - '],
            ['title' => 'อนุมัติ', 'count' => $countApproved, 'class' => 'status-approved', 'icon' => 'uil-check-circle', 'last_update' => $lastUpdateApproved ?? ' - '],
            ['title' => 'ถูกปฏิเสธ', 'count' => $countRejected, 'class' => 'status-rejected', 'icon' => 'uil-ban', 'last_update' => $lastUpdateRejected ?? ' - '],
            ['title' => 'คืนแล้ว', 'count' => $countCompleted, 'class' => 'status-completed', 'icon' => 'uil-box', 'last_update' => $lastUpdateCompleted ?? ' - '],
        ];
    @endphp

    @foreach ($statuses as $status)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-2">
        <div class="card status-card {{ $status['class'] }}">
            <div class="card-body p-3"> 
                <div class="d-flex align-items-center">
                    <i class="{{ $status['icon'] }}" style="font-size: 30px; opacity: 0.6;"></i> 
                    <div class="ms-2">
                        <h6 class="status-title">{{ $status['title'] }}</h6> 
                        <h3 class="stat-number">{{ $status['count'] }}</h3> 
                    </div>
                </div>
                <div class="mt-2 text-start">
                    <span class="last-update">⬆ อัปเดตล่าสุด  {{ $status['last_update'] }}</span> 
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


<!-- ✅ ตัวกรองข้อมูล -->
<div class="row align-items-center mb-0">
    <!-- ✅ ปุ่ม Export Excel -->
    <div class="col-lg-6 col-md-6 col-sm-12 text-start mb-2 mb-md-0">
        <a href="{{ route('borrow.export') }}" class="btn btn-success shadow-sm fw-bold px-4">
            <i class="fa-solid fa-file-excel me-2"></i> Export to Excel
        </a>
    </div>

    <!-- ✅ ตัวกรองสถานะ -->
    <div class="col-lg-6 col-md-6 col-sm-12 text-md-end text-start">
        <form method="GET" action="{{ route('borrowlist') }}" class="d-flex align-items-center justify-content-md-end">
            <label for="statusFilter" class="form-label me-2 fw-bold text-dark" style="font-size: 1rem;">สถานะ:</label>
            <select class="form-select form-select-md shadow-sm border-2" name="status" id="statusFilter" onchange="this.form.submit()" style="max-width: 200px;">
                <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>📋 ทั้งหมด</option>
                <option value="pending" {{ ($statusFilter ?? '') == 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                <option value="approved" {{ ($statusFilter ?? '') == 'approved' ? 'selected' : '' }}>✅ อนุมัติ</option>
                <option value="rejected" {{ ($statusFilter ?? '') == 'rejected' ? 'selected' : '' }}>🚫 ถูกปฏิเสธ</option>
                <option value="completed" {{ ($statusFilter ?? '') == 'completed' ? 'selected' : '' }}>📦 คืนแล้ว</option>
            </select>
        </form>
    </div>
</div>

<!-- ✅ แจ้งเตือนเมื่ออนุมัติสำเร็จ -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ❌ แจ้งเตือนเมื่อปฏิเสธสำเร็จ -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ✅ ตารางข้อมูล -->
<div class="table-responsive">
    <table id="borrowTable" ">
    <thead class="table-dark text-center">
        <tr>
            <th class="fs-4 fw-bold py-3">ไอดี</th>
            <th class="fs-4 fw-bold py-3">ชื่อผู้ยืม</th>
            <th class="fs-4 fw-bold py-3">ชื่อหรือประเภทของครุภัณฑ์</th>
            <th class="fs-4 fw-bold py-3">สถานที่ยืม</th>
            <th class="fs-4 fw-bold py-3">หมายเลขครุภัณฑ์</th>
            <th class="fs-4 fw-bold py-3">วันที่ขอยืม</th>
            <th class="fs-4 fw-bold py-3">วันที่คืน</th> <!-- ✅ เพิ่มส่วนนี้ -->
            <th class="fs-4 fw-bold py-3">รายละเอียด</th>
            <th class="fs-4 fw-bold py-3">สถานะ</th>
            <th class="fs-4 fw-bold py-3">จัดการคำร้อง</th>
        </tr>
    </thead>

        <tbody>
                @foreach ($borrowRequests as $borrow)
                    <tr class="text-center">
                        <td class="fs-5 py-2">{{ $borrow->id }}</td>
                        <td class="fs-5 py-2">{{ $borrow->borrower_name ?? 'ไม่ระบุ' }}</td>
                        <td class="fs-5 py-2">{{ $borrow->asset->asset_name ?? 'ไม่มีข้อมูล' }}</td>
                        <td class="fs-5 py-2">{{ $borrow->location ?? 'ไม่ระบุสถานที่' }}</td>
                        <td class="fs-5 py-2">{{ $borrow->asset->asset_number ?? 'ไม่มีข้อมูล' }}</td>
                        <!-- ✅ แปลงวันที่เป็น "วัน/เดือน/ปี (d/m/Y)" -->
                        <td class="fs-5 py-2">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                        <td class="fs-5 py-2">
                            {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="fs-5 py-2">{{ $borrow->note ?? 'ไม่มีข้อมูล' }}</td>
                        <td class="fw-bold align-middle">
                            @if ($borrow->status == 'pending')
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-warning dropdown-toggle fw-bold py-2 px-3 w-100" data-bs-toggle="dropdown">
                                        ⏳รอดำเนินการ
                                    </button>
                                    <ul class="dropdown-menu text-center ">
                                        <li>
                                            <form action="{{ route('borrow.approve', $borrow->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item text-success fw-bold py-2" onclick="return confirm('ยืนยันการอนุมัติ?')">
                                                    ✅ อนุมัติ
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('borrow.reject', $borrow->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item text-danger fw-bold py-2" onclick="return confirm('ยืนยันการปฏิเสธ?')">
                                                    ❌ ปฏิเสธ
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @elseif ($borrow->status == 'approved')
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-success dropdown-toggle fw-bold py-2 px-3 w-100" data-bs-toggle="dropdown">
                                    ✅อนุมัติ
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <li>
                                            <form action="{{ route('borrow.return', $borrow->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item text-primary fw-bold py-2" onclick="return confirm('คุณต้องการทำรายการคืนใช่หรือไม่?')">
                                                    📦 คืนแล้ว
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                            @php
                                $statusClasses = [
                                    'pending' => 'status-badge status-pending',
                                    'approved' => 'status-badge status-approved',
                                    'rejected' => 'status-badge status-rejected',
                                    'completed' => ($borrow->return_date)
                                        ? 'status-badge status-completed'
                                        : 'status-badge status-secondary'
                                ];

                                $statusText = [
                                    'pending' => '⏳ รอดำเนินการ',
                                    'approved' => '✅ อนุมัติ',
                                    'rejected' => '🚫 ถูกปฏิเสธ',
                                    'completed' => ($borrow->return_date) ? '📦 คืนแล้ว' : '⚠️ คืนแล้ว (ไม่มีวันที่คืน)'
                                ];
                            @endphp

                            <span class="{{ $statusClasses[$borrow->status] ?? 'status-badge status-secondary' }}">
                                {!! $statusText[$borrow->status] ?? 'ไม่ทราบสถานะ' !!}
                            </span>

                            @endif
                        </td>

                        <!-- ✅ ปุ่มแก้ไข / ลบ -->
                        <td class="align-middle">
                            <div class="btn-group">
                                <button type="button" class="btn custom-btn fw-bold py-2 px-3 dropdown-toggle" data-bs-toggle="dropdown">
                                    ⚙️ จัดการ
                                </button>
                                <ul class="dropdown-menu text-center delete-menu">
                                    <li>
                                        <form action="{{ route('borrow.destroy', $borrow->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold py-2 delete-btn" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำร้องนี้?')">
                                                🗑️ ลบคำร้อง
                                            </button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
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
            "language": {
                "search": "",
                "searchPlaceholder": "🔍 ค้นหา...",
                "lengthMenu": "แสดง _MENU_ รายการ",
                "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                },
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "infoEmpty": "ไม่มีรายการ",
                "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
            }
        });
    });
</script>
@endsection

