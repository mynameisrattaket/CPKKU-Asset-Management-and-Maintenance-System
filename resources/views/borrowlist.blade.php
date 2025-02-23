@extends('layoutmenu')

@section('title', 'รายการคำร้องขอยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title fw-bold">📌 รายการคำร้องขอยืมครุภัณฑ์</h4>
@endsection

@section('conten')

<!-- ✅ ส่วนแสดงผลสรุป -->
<div class="row">
    <!-- รอดำเนินการ -->
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one shadow border-0">
            <div class="card-body d-flex align-items-center">
                <i class="uil-clock float-end" style="font-size: 45px; color: #007bff;"></i> <!-- ⏳ -->
                <div>
                    <h5 class="fw-bold text-primary mb-1">รอดำเนินการ</h5>
                    <h2 class="mb-0 text-primary">{{ $countPending }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- ถูกปฏิเสธ -->
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one shadow border-0">
            <div class="card-body d-flex align-items-center">
                <i class='uil-ban float-end' style="font-size: 45px; color: #dc3545;"></i> <!-- ❌ -->
                <div>
                    <h5 class="fw-bold text-danger mb-1">ถูกปฏิเสธ</h5>
                    <h2 class="mb-0 text-danger">{{ $countRejected }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- อนุมัติ -->
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one shadow border-0">
            <div class="card-body d-flex align-items-center">
                <i class='uil-check-circle float-end' style="font-size: 45px; color: #ffc107;"></i> <!-- ✅ -->
                <div>
                    <h5 class="fw-bold text-warning mb-1">อนุมัติ</h5>
                    <h2 class="mb-0 text-warning">{{ $countApproved }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- คืนแล้ว -->
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one shadow border-0">
            <div class="card-body d-flex align-items-center">
                <i class="uil-box float-end" style="font-size: 45px; color: #28a745;"></i> <!-- 📦 -->
                <div>
                    <h5 class="fw-bold text-success mb-1">คืนแล้ว</h5>
                    <h2 class="mb-0 text-success">{{ $countCompleted }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ ตัวกรองข้อมูล -->
<div class="d-flex justify-content-between align-items-center mb-3 mt-3">
    <a href="{{ route('borrow.export') }}" class="btn btn-success">
        <i class="fa-solid fa-file-excel"></i> Export to Excel
    </a>

    <div class="col-md-3">
        <form method="GET" action="{{ route('borrowlist') }}">
            <div class="d-flex align-items-center">
                <label for="statusFilter" class="form-label me-2 fw-bold">กรองสถานะ</label>
                <select class="form-select" name="status" id="statusFilter" onchange="this.form.submit()">
                    <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>ทั้งหมด</option>
                    <option value="pending" {{ ($statusFilter ?? '') == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                    <option value="approved" {{ ($statusFilter ?? '') == 'approved' ? 'selected' : '' }}>อนุมัติ</option>
                    <option value="rejected" {{ ($statusFilter ?? '') == 'rejected' ? 'selected' : '' }}>ถูกปฏิเสธ</option>
                    <option value="completed" {{ ($statusFilter ?? '') == 'completed' ? 'selected' : '' }}>คืนแล้ว</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- ✅ แจ้งเตือนเมื่ออนุมัติสำเร็จ -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ❌ แจ้งเตือนเมื่อปฏิเสธสำเร็จ -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ❌ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<!-- ✅ ตารางข้อมูล -->
<table id="borrowTable" class="table table-bordered table-hover shadow">
    <thead class="table-dark">
        <tr class="text-center">
            <th>ไอดี</th>
            <th>ชื่อผู้ยืม</th>
            <th>ชื่อหรือประเภทของครุภัณฑ์</th>
            <th>รายละเอียด</th>
            <th>สถานที่ยืม</th>
            <th>หมายเลขครุภัณฑ์</th>
            <th>วันที่ขอยืม</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($borrowRequests as $borrow)
        <tr class="text-center">
            <td>{{ $borrow->id }}</td>
            <td>{{ $borrow->borrower_name ?? 'ไม่ระบุ' }}</td>
            <td>{{ $borrow->asset->asset_name ?? 'ไม่มีข้อมูล' }}</td>
            <td>{{ $borrow->asset->asset_detail ?? 'ไม่มีข้อมูล' }}</td>
            <td>{{ $borrow->location ?? 'ไม่ระบุสถานที่' }}</td>
            <td>{{ $borrow->asset->asset_number ?? 'ไม่มีข้อมูล' }}</td>
            <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>

            <td class="fw-bold">
            @if ($borrow->status == 'pending')
                <div class="btn-group">
                    <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        ⏳ รอดำเนินการ
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="{{ route('borrow.approve', $borrow->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item text-success" onclick="return confirm('ยืนยันการอนุมัติ?')">
                                    ✅ อนุมัติ
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('borrow.reject', $borrow->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('ยืนยันการปฏิเสธ?')">
                                    ❌ ปฏิเสธ
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                @php
                    $statusText = [
                        'approved' => '<span class="text-success">✅ อนุมัติ</span>',
                        'rejected' => '<span class="text-danger">❌ ถูกปฏิเสธ</span>',
                        'completed' => '<span class="text-primary">📦 คืนแล้ว</span>'
                    ];
                @endphp
                {!! $statusText[$borrow->status] ?? '<span class="text-muted">ไม่ทราบสถานะ</span>' !!}
            @endif
        </td>

        </tr>
    @endforeach
    </tbody>
</table>



@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#borrowTable').DataTable({
            "language": {
                "search": "",
                "searchPlaceholder": "ค้นหา",
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showAlert("{{ session('success') }}", 'success');
        @endif
    });

    function showAlert(message, type) {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type} alert-dismissible fade show`;
        alertContainer.role = 'alert';
        alertContainer.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.prepend(alertContainer);
        setTimeout(() => {
            alertContainer.remove();
        }, 5000);
    }
</script>

@endsection
