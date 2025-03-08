@extends('layoutmenu')

@section('title', '📜 ประวัติการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title text-center fw-bold">📜 ประวัติการยืมครุภัณฑ์</h4>
@endsection

@section('conten')

<div class="container mt-3">

    <!-- 🔍 ฟอร์มสำหรับค้นหา -->
    <div class="card shadow-sm border-0 p-4">
        <form id="searchForm" action="{{ route('borrowhistory') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" class="form-control shadow-sm" placeholder="🔍 ค้นหาครุภัณฑ์ (ชื่อ/หมายเลข)" name="searchasset" value="{{ request('searchasset') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control shadow-sm" placeholder="👤 ชื่อ-นามสกุล" name="borrower_name" value="{{ request('borrower_name') }}">
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary fw-bold shadow-sm" type="submit">
                        <i class="fas fa-search"></i> ค้นหา
                    </button>
                </div>
            </div>
            <div class="row g-2 mt-3">
                <div class="col-md-4">
                    <label for="borrow_date" class="form-label fw-bold">📅 วันที่ยืม:</label>
                    <input type="date" class="form-control shadow-sm" id="borrow_date" name="borrow_date" value="{{ request('borrow_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="return_date" class="form-label fw-bold">📅 วันที่คืน:</label>
                    <input type="date" class="form-control shadow-sm" id="return_date" name="return_date" value="{{ request('return_date') }}">
                </div>
                <!-- ✅ ปุ่มเคลียร์ -->
                <div class="col-md-4 d-flex align-items-end">
                    <a href="{{ route('borrowhistory') }}" class="btn btn-outline-secondary fw-bold shadow-sm px-2 py-1"
                       style="font-size: 0.75rem; line-height: 1; display: inline-flex; align-items: center;">
                        <i class="fas fa-sync-alt fa-2xs me-1"></i> เคลียร์
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ✅ ตารางแสดงผล -->
    <div class="table-responsive mt-4 shadow-sm">
        <table id="borrowTable" class="table table-hover table-bordered align-middle">
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
                            <!-- ✅ ดึงสถานะจาก borrow_requests และแปลงเป็นภาษาไทย -->
                            @php
                                $statusColors = [
                                    'pending' => 'badge bg-secondary text-dark shadow-lg',
                                    'approved' => 'badge bg-success text-white shadow-lg',
                                    'rejected' => 'badge bg-danger text-white shadow-lg',
                                    'completed' => 'badge bg-info text-dark shadow-lg'
                                ];

                                // สถานะจากฐานข้อมูล
                                $status = $request->status ?? 'pending'; // ถ้าไม่มีสถานะให้ตั้งค่าเป็น pending
                                // แปลงสถานะเป็นภาษาไทย
                                $statusText = [
                                    'pending' => 'รออนุมัติ',
                                    'approved' => 'ได้รับอนุมัติ',
                                    'rejected' => 'ถูกปฏิเสธ',
                                    'completed' => 'คืนแล้ว'
                                ][$status] ?? 'ไม่ระบุ'; // แปลงเป็นภาษาไทย
                                // เลือกสีของ badge ตามสถานะ
                                $statusClass = $statusColors[$status] ?? 'badge bg-light';
                            @endphp
                            <span class="{{ $statusClass }}" style="padding: 5px 15px; font-weight: bold; border-radius: 50px;">
                                {{ $statusText }}
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
                search: "🔍 ค้นหา: ",
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
