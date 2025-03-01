@extends('layoutmenu')

@section('title', 'ค้นหาประวัติการซ่อม')

@section('contentitle')
    <h4 class="page-title">ค้นหาประวัติการซ่อม</h4>
@endsection

@section('conten')
<div class="container-fluid">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('searchrepair') }}" method="GET" class="mb-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="ค้นหาประวัติการซ่อม" aria-label="ค้นหาประวัติการซ่อม" name="searchasset">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="หมายเลขครุภัณฑ์" name="asset_number">
            <input type="text" class="form-control" placeholder="รายละเอียดอาการเสีย" name="asset_symptom_detail">
            <input type="text" class="form-control" placeholder="สถานที่" name="location">
            <input type="text" class="form-control" placeholder="บันทึกการซ่อม" name="request_repair_note">
        </div>
    </form>

    <!-- ตารางแสดงผลลัพธ์การค้นหา -->
    <table id="repairTable" class="table table-bordered table-sm mt-4">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>ชื่อหรือประเภทของอุปกรณ์</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>รายละเอียดอาการเสีย</th>
                <th>สถานที่</th>
                <th>บันทึกการซ่อม</th>
            </tr>
        </thead>
        <tbody>
            @if($search->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @else
                @foreach($search as $repair)
                <tr>
                    <td>{{ $repair->request_detail_id }}</td>
                    <td>{{ $repair->asset_name }}</td>
                    <td>{{ $repair->asset_number }}</td>
                    <td>{{ $repair->asset_symptom_detail }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>{{ $repair->request_repair_note }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <!-- DataTable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable without search box
            $('#repairTable').DataTable({
                searching: false,  // Disable the search box
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'ทั้งหมด']
                ],
                language: {
                    lengthMenu: 'แสดง _MENU_ รายการต่อหน้า',
                    info: 'แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ',
                    paginate: {
                        previous: 'ก่อนหน้า',
                        next: 'ถัดไป'
                    }
                }
            });
        });
    </script>

    <style>
        /* ทำให้ฟอร์มค้นหายืดเต็มจอ */
        #searchForm {
            width: 100%;
        }
        .input-group {
            width: 100%;
        }
        /* ให้กล่องค้นหาคงขนาดเดิม */
        .form-control {
            width: auto;
        }

    </style>
@endsection
