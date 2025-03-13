@extends('layoutmenu')

@section('title', 'รายการคำร้องขอยืมครุภัณฑ์')

<style>
    /* ตารางข้อมูล*/

    .table-dark.text-center th {  /* ปรับหัวตารางข้อมูล*/
    background-color:rgb(30, 44, 59);; ;
    color: #ffffff;
    text-align: center;
    font-size: 16px !important;
    white-space: nowrap;  
    padding-top: 20px !important;
    padding-bottom: 20px !important;
}

    #borrowTable {  /* กำหนดค่าพื้นฐานให้กับตาราง */
        text-align: center;
        border-collapse: collapse; /* ทำให้เส้นขอบติดกัน */
        width: 100%;
        margin: auto; /* จัดให้ตารางอยู่ตรงกลาง */
        font-size: 14px; /* ลดขนาดตัวอักษรภายในตาราง */
    }

    #borrowTable th, #borrowTable td {  /* ปรับสไตล์ให้กับหัวตาราง (<th>) และเซลล์ข้อมูล (<td>) */
        font-size: 15px ;
        text-align: center;
        border-right: 0.5px solid rgb(35, 57, 77); 
    }
    /* เซลข้อมูล */
    #borrowTable tbody td {
    border-right: 1px solid rgba(214, 214, 214, 0.2);   /* เพิ่มแถบเส้นกั้นระหว่างคอลัมน์ */
    border-left: 1px solid rgba(214, 214, 214, 0.2);
    border-bottom: 1px solid rgba(214, 214, 214, 0.2); /* เส้นขอบสีเทาอ่อน */
    padding: 5px;
}
    
    #borrowTable tbody tr:nth-child(odd) {
    background-color:rgb(248, 248, 248) !important; /* แถวคี่ */
        color:rgb(0, 5, 9);
}

    #borrowTable tbody tr:nth-child(even) {
    background-color: #ffffff !important; /*แถวคู่ */
    color:rgb(3, 17, 29);
}
/* ✅ ปรับขนาดป้ายสถานะ */
/* ✅ ปรับป้ายสถานะให้ตัวหนังสืออยู่ตรงกลาง */
#borrowTable .status-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 !important;  /* ลด Padding ให้ไม่เบี้ยว */
    font-size: 16px !important;
    font-weight: bold !important;
    border-radius: 8px !important;
    text-align: center;
    width: 160px;
    height: 45px;
    transition: all 0.3s ease-in-out;
    box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2); /* ✅ เพิ่มเงา */
    border: 2px solid rgba(0, 0, 0, 0.3) !important; /* ✅ เพิ่มขอบ */
    cursor: default;
}

/* ✅ ปรับ dropdown button ให้ตัวหนังสืออยู่ตรงกลาง */
#borrowTable .btn-group {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 160px !important;
    height: 45px !important;
}

/* ✅ ปรับขนาดปุ่ม dropdown และให้ตัวหนังสืออยู่ตรงกลาง */
#borrowTable .btn-group .btn {
    display: flex;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    font-size: 16px !important;
    font-weight: bold !important;
    border-radius: 8px !important; /* ✅ ทำให้ขอบมน */
    border: 2px solid rgba(0, 0, 0, 0.3) !important; /* ✅ เพิ่มขอบ */
    text-align: center;
}

/* ✅ รอดำเนินการ (สีเหลืองสด) */
#borrowTable .status-pending {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #FFC107, #FFB300) !important;
    color: #000 !important;
    border-color: #E6A700 !important;
    width: 100% !important;
    height: 100% !important;
}

/* ✅ อนุมัติ (สีเขียวสด) */
#borrowTable .status-approved {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #00C853, #009624) !important;
    color: #fff !important;
    border-color: #008000 !important;
}

/* ✅ ถูกปฏิเสธ (สีแดงสด) */
#borrowTable .status-rejected {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #D50000, #FF1744) !important;
    color: #fff !important;
    border-color:rg(135deg, #D50000, #FF1744) !important;
}

/* ✅ คืนแล้ว (สีฟ้าสด) */
#borrowTable .status-completed {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2962FF, #1E88E5) !important;
    color: #fff !important;
    border-color:rgb(135deg, #2962FF, #1E88E5) !important;
}

/* ⚪️ สำรองสีเทาสำหรับสถานะอื่น */
#borrowTable .status-secondary {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #9E9E9E, #BDBDBD) !important;
    color: #fff !important;
    border-color: #757575 !important;
}


    /* สิ้นสุดCSSตารางข้อมูล*/
    
    /* จัดการคำร้อง*/
        .custom-btn {
        background-color:rgb(0, 0, 0) !important; /* สีพื้นหลัง */
        border-color: #014374 !important; /* สีขอบ */
        color: white !important; /* สีตัวอักษร */
        transition: all 0.3s ease-in-out;
    }

.custom-btn:hover, .custom-btn:focus {
    background-color: #014374 !important; /* สีเข้มขึ้นเมื่อ hover */
    border-color: #01325a !important;
    box-shadow: 0px 4px 10px rgba(1, 87, 155, 0.3); /* เพิ่มเงา */
}
    /* สิ้นสุดCSSจัดการคำร้อง*/

    /*  สรุปผลข้อมูล */

    .status-card h5 {
        font-size: 1.8rem !important;
    }

    .status-card h2 {
        font-size: 1.5rem !important;
    }

    .status-card span {
        font-size: 1rem !important;
    }

    .status-card {
    
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: white;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        font-size: 1.2rem; /* ✅ เพิ่มขนาดตัวหนังสือ */
    }

    .status-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(0, 0, 0, 0.15) 100%);
        z-index: 1;
    }

    /* 🎨 สีพื้นหลังแบบ Gradient */
    .status-pending { background: linear-gradient(135deg,rgb(225, 233, 162),rgb(255, 242, 148)); }
    .status-rejected { background: linear-gradient(135deg,rgb(238, 199, 199),rgb(238, 175, 209)); }
    .status-approved { background: linear-gradient(135deg,rgb(197, 240, 197),rgb(212, 224, 224)); }
    .status-completed { background: linear-gradient(135deg,rgb(212, 201, 245),rgb(214, 210, 251)); }

    /* 📌 ไอคอนแบบโปร่งแสง */
    .status-card i {
        font-size: 100px;
        position: absolute;
        right: 20px;
        top: 20px;
        opacity: 0.2;
    }
    /* 🎨 สีตัวหนังสือของแต่ละสถานะ */
    .status-pending h6, .status-pending h3, .status-pending span {
        color:rgb(55, 38, 0) !important; /* สีน้ำตาลเข้ม */
    }

    .status-rejected h6, .status-rejected h3, .status-rejected span {
        color:rgb(39, 0, 0) !important; /* สีแดงเข้ม */
    }

    .status-approved h6, .status-approved h3, .status-approved span {
        color:rgb(0, 45, 39) !important; /* สีเขียวเข้ม */
    }

    .status-completed h6, .status-completed h3, .status-completed span {
        color:rgb(35, 0, 79) !important; /* สีน้ำเงินเข้ม */
    }
    /*  สิ้นสุดCSSสรุปผลข้อมูล */


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
                        <h6 class="fw-bold text-white mb-1" style="font-size: 1rem;">{{ $status['title'] }}</h6> 
                        <h3 class="mb-0 fw-bold text-white" style="font-size: 1.8rem;">{{ $status['count'] }}</h3>
                    </div>
                </div>
                <div class="mt-2 text-start">
                    <span class="text-success fw-bold" style="font-size: 0.85rem;">⬆ อัปเดตล่าสุด</span> 
                    <span class="text-light" style="font-size: 0.85rem;"> 
                        {{ $status['last_update'] != ' - ' ? \Carbon\Carbon::parse($status['last_update'])->format('d/m/Y H:i') : '-' }}
                    </span>
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
            <th class="fs-4 fw-bold py-3">รายละเอียด</th>
            <th class="fs-4 fw-bold py-3">สถานที่ยืม</th>
            <th class="fs-4 fw-bold py-3">หมายเลขครุภัณฑ์</th>
            <th class="fs-4 fw-bold py-3">วันที่ขอยืม</th>
            <th class="fs-4 fw-bold py-3">วันที่คืน</th> <!-- ✅ เพิ่มส่วนนี้ -->
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
                        <td class="fs-5 py-2">{{ $borrow->note ?? 'ไม่มีข้อมูล' }}</td>
                        <td class="fs-5 py-2">{{ $borrow->location ?? 'ไม่ระบุสถานที่' }}</td>
                        <td class="fs-5 py-2">{{ $borrow->asset->asset_number ?? 'ไม่มีข้อมูล' }}</td>

                        <!-- ✅ แปลงวันที่เป็น "วัน/เดือน/ปี (d/m/Y)" -->
                        <td class="fs-5 py-2">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                        <td class="fs-5 py-2">
                            {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') : '-' }}
                        </td>

                        <td class="fw-bold align-middle">
                            @if ($borrow->status == 'pending')
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-warning dropdown-toggle fw-bold py-2 px-3 w-100" data-bs-toggle="dropdown">
                                        ⏳รอดำเนินการ
                                    </button>
                                    <ul class="dropdown-menu text-center w-100">
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
                                    <ul class="dropdown-menu text-center w-100">
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
                                <ul class="dropdown-menu text-center w-100">
                                    <li>
                                        <form action="{{ route('borrow.destroy', $borrow->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold py-2" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำร้องนี้?')">
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

