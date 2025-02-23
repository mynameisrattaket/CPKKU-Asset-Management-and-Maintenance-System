@extends('layoutmenu')

@section('title', 'รายการคำร้องขอยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title fw-bold">📌 รายการคำร้องขอยืมครุภัณฑ์</h4>
@endsection

@section('conten')

<!-- ✅ ส่วนแสดงผลสรุป -->
<!-- ✅ ส่วนแสดงผลสรุป พร้อม Animation -->
<div class="row">
    <!-- การ์ดสถานะ -->
    @php
        $statuses = [
            ['title' => 'รอดำเนินการ', 'count' => $countPending, 'color' => '#007bff', 'icon' => 'uil-clock'],
            ['title' => 'ถูกปฏิเสธ', 'count' => $countRejected, 'color' => '#dc3545', 'icon' => 'uil-ban'],
            ['title' => 'อนุมัติ', 'count' => $countApproved, 'color' => '#ffc107', 'icon' => 'uil-check-circle'],
            ['title' => 'คืนแล้ว', 'count' => $countCompleted, 'color' => '#28a745', 'icon' => 'uil-box'],
        ];
    @endphp

    @foreach ($statuses as $status)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="card tilebox-one shadow border-0 animate__animated animate__fadeIn">
            <div class="card-body d-flex align-items-center p-4"
                 style="border-radius: 10px; transition: transform 0.3s ease, box-shadow 0.3s ease;"
                 onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.2)';"
                 onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 5px 10px rgba(0,0,0,0.1)';">
                 
                <i class="{{ $status['icon'] }} float-end" style="font-size: 50px; color: {{ $status['color'] }};"></i>
                <div class="ms-3">
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem;">{{ $status['title'] }}</h5>
                    <h2 class="mb-0 fw-bold" style="font-size: 2rem; color: {{ $status['color'] }};">{{ $status['count'] }}</h2>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


<!-- ✅ ตัวกรองข้อมูล -->
<div class="row align-items-center mb-4">
    <!-- ปุ่ม Export Excel -->
    <div class="col-md-4 text-start">
        <a href="{{ route('borrow.export') }}" class="btn btn-lg btn-success shadow-sm fw-bold px-4">
            <i class="fa-solid fa-file-excel me-2"></i> Export to Excel
        </a>
    </div>

    <!-- ตัวกรองสถานะ -->
    <div class="col-md-4 offset-md-4 text-end">
        <form method="GET" action="{{ route('borrowlist') }}" class="d-flex align-items-center">
        <label for="statusFilter" class="form-label me-2 fw-bold text-dark" style="font-size: 1.2rem; display: inline-block; min-width: 70px;">สถานะ:</label>
            <select class="form-select form-select-lg shadow-sm border-2" name="status" id="statusFilter" onchange="this.form.submit()">
                <option value="all" {{ ($statusFilter ?? 'all') == 'all' ? 'selected' : '' }}>📋 ทั้งหมด</option>
                <option value="pending" {{ ($statusFilter ?? '') == 'pending' ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
                <option value="approved" {{ ($statusFilter ?? '') == 'approved' ? 'selected' : '' }}>✅ อนุมัติ</option>
                <option value="rejected" {{ ($statusFilter ?? '') == 'rejected' ? 'selected' : '' }}>❌ ถูกปฏิเสธ</option>
                <option value="completed" {{ ($statusFilter ?? '') == 'completed' ? 'selected' : '' }}>📦 คืนแล้ว</option>
            </select>
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
<div class="table-responsive">
    <table id="borrowTable" class="table table-striped table-hover table-bordered shadow-lg align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th class="fs-4 fw-bold py-3">ไอดี</th>
                <th class="fs-4 fw-bold py-3">ชื่อผู้ยืม</th>
                <th class="fs-4 fw-bold py-3">ชื่อหรือประเภทของครุภัณฑ์</th>
                <th class="fs-4 fw-bold py-3">รายละเอียด</th>
                <th class="fs-4 fw-bold py-3">สถานที่ยืม</th>
                <th class="fs-4 fw-bold py-3">หมายเลขครุภัณฑ์</th>
                <th class="fs-4 fw-bold py-3">วันที่ขอยืม</th>
                <th class="fs-4 fw-bold py-3">สถานะ</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($borrowRequests as $borrow)
            <tr class="text-center">
                <td class="fs-5 py-2">{{ $borrow->id }}</td>
                <td class="fs-5 py-2">{{ $borrow->borrower_name ?? 'ไม่ระบุ' }}</td>
                <td class="fs-5 py-2">{{ $borrow->asset->asset_name ?? 'ไม่มีข้อมูล' }}</td>
                <td class="fs-5 py-2">{{ $borrow->asset->asset_detail ?? 'ไม่มีข้อมูล' }}</td>
                <td class="fs-5 py-2">{{ $borrow->location ?? 'ไม่ระบุสถานที่' }}</td>
                <td class="fs-5 py-2">{{ $borrow->asset->asset_number ?? 'ไม่มีข้อมูล' }}</td>
                <td class="fs-5 py-2">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>

                <td class="fw-bold align-middle">
                    @if ($borrow->status == 'pending')
                        <div class="btn-group w-100">
                            <button type="button" class="btn btn-warning dropdown-toggle fw-bold py-2 px-3 w-100" data-bs-toggle="dropdown">
                                ⏳ รอดำเนินการ
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
                    @else
                        @php
                            $statusClasses = [
                                'approved' => 'bg-success text-white d-block text-center py-2 px-3 w-100 rounded',
                                'rejected' => 'bg-danger text-white d-block text-center py-2 px-3 w-100 rounded',
                                'completed' => 'bg-primary text-white d-block text-center py-2 px-3 w-100 rounded'
                            ];
                            $statusText = [
                                'approved' => '✅ อนุมัติ',
                                'rejected' => '❌ ถูกปฏิเสธ',
                                'completed' => '📦 คืนแล้ว'
                            ];
                        @endphp
                        <span class="{{ $statusClasses[$borrow->status] ?? 'bg-secondary text-white d-block text-center py-2 px-3 w-100 rounded' }}">
                            {!! $statusText[$borrow->status] ?? 'ไม่ทราบสถานะ' !!}
                        </span>
                    @endif
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

