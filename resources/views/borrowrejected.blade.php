@extends('layoutmenu')

@section('title', 'รายการคำร้องถูกปฏิเสธ')

@section('contentitle')
    <h4 class="page-title">รายการคำร้องที่ถูกปฏิเสธ</h4>
@endsection

@section('conten')
<div class="container">
    <table id="rejectedBorrowTable" class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">หมายเลขอุปกรณ์</th>
                <th scope="col">ชื่ออุปกรณ์</th>
                <th scope="col">ชื่อผู้ยืม</th>
                <th scope="col">วันที่ยืม</th>
                <th scope="col">วันที่คืน</th>
                <th scope="col">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rejectedBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->id }}</td>
                    <td>{{ $borrow->asset->asset_number ?? 'N/A' }}</td>
                    <td>{{ $borrow->asset->asset_name ?? 'N/A' }}</td>
                    <td>{{ $borrow->borrower_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
                    <td><span class="badge bg-danger">ปฏิเสธ</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#rejectedBorrowTable').DataTable({
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
