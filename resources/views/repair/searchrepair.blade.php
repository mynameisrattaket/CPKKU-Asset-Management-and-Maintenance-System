@extends('layoutmenu')

@section('title', 'ค้นหาประวัติการซ่อม')

@section('contentitle')
    <h4 class="page-title">ค้นหาประวัติการซ่อม</h4>
@endsection

@section('conten')
<div class="container-fluid">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" class="mb-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="searchasset" placeholder="ค้นหาประวัติการซ่อม" aria-label="ค้นหาประวัติการซ่อม">
            <button class="btn btn-primary" type="submit" style="display:none;">ค้นหา</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="asset_number" placeholder="หมายเลขครุภัณฑ์">
            <input type="text" class="form-control" id="asset_symptom_detail" placeholder="รายละเอียดอาการเสีย">
            <input type="text" class="form-control" id="location" placeholder="สถานที่">
            <input type="text" class="form-control" id="request_repair_note" placeholder="บันทึกการซ่อม">
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
            <!-- ผลลัพธ์จะแสดงที่นี่ -->
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

            @if($search->isEmpty())
            <tr>
                <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
            </tr>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // ฟังก์ชั่นค้นหาแบบ Real-time
            $('#searchForm input').on('input', function () {
                var searchasset = $('#searchasset').val();
                var asset_number = $('#asset_number').val();
                var asset_symptom_detail = $('#asset_symptom_detail').val();
                var location = $('#location').val();
                var request_repair_note = $('#request_repair_note').val();

                // ส่งคำค้นหาผ่าน AJAX
                $.ajax({
                    url: '{{ route("searchrepair") }}',
                    method: 'GET',
                    data: {
                        searchasset: searchasset,
                        asset_number: asset_number,
                        asset_symptom_detail: asset_symptom_detail,
                        location: location,
                        request_repair_note: request_repair_note
                    },
                    success: function (response) {
                        // แสดงผลลัพธ์ในตาราง
                        $('#repairTable tbody').html(response);
                    }
                });
            });
        });
    </script>
@endsection
