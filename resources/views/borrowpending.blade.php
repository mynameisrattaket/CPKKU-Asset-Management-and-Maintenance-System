@extends('layoutmenu')

@section('title', 'รอดำเนินการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">รายการรอดำเนินการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <table id="pendingBorrowTable" class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col">ไอดี</th>
                <th scope="col">หมายเลขอุปกรณ์</th>
                <th scope="col">ชื่ออุปกรณ์</th>
                <th scope="col">ชื่อผู้ยืม</th>
                <th scope="col">วันที่ยืม</th>
                <th scope="col">วันที่คืน</th>
                <th scope="col">สถานะ</th>
                <th scope="col">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->id }}</td>
                    <td>{{ $borrow->asset->asset_number ?? 'N/A' }}</td>
                    <td>{{ $borrow->asset->asset_name ?? 'N/A' }}</td>
                    <td>{{ $borrow->borrower_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
                    <td><span class="badge bg-warning">รอดำเนินการ</span></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal{{ $borrow->id }}">รายละเอียด</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($pendingBorrows as $borrow)
        <div class="modal fade" id="borrowModal{{ $borrow->id }}" tabindex="-1" aria-labelledby="borrowModalLabel{{ $borrow->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="borrowModalLabel{{ $borrow->id }}">รายละเอียดการยืมครุภัณฑ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="{{ route('updateBorrowStatus', $borrow->id) }}">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="borrowStatus{{ $borrow->id }}" class="form-label">สถานะ</label>
            <select class="form-select" id="borrowStatus{{ $borrow->id }}" name="borrow_status">
                <option value="pending" {{ $borrow->status === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                <option value="approved">อนุมัติ</option>
                <option value="rejected">ปฏิเสธ</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#pendingBorrowTable').DataTable({
            "language": {
                "search": "ค้นหา:",
                "lengthMenu": "แสดง _MENU_ รายการ",
                "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                },
                "zeroRecords": "ไม่พบข้อมูล",
                "infoEmpty": "ไม่มีรายการ",
                "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
            }
        });
    });
</script>
@endsection
