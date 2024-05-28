@extends('layoutmenu')

@section('title', 'รายการแจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">รายการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <div class="col-3 text-end mb-2 mt-2"></div>
    <table id="repairTable" class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">ชื่อหรือประเภทของอุปกรณ์</th>
                <th scope="col">รายละเอียดอาการเสีย</th>
                <th scope="col">สถานที่</th>
                <th scope="col">หมายเลขครุภัณฑ์</th>
                <th scope="col">วันที่แจ้งซ่อม</th>
                <th scope="col">สถานะการซ่อม</th>
                <th scope="col">รายละเอียดเพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairs as $repair)
                <tr>
                    <td>{{ $repair->request_detail_id }}</td>
                    <td>{{ $repair->asset_name }}</td>
                    <td>{{ $repair->asset_symptom_detail }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>{{ $repair->asset_number }}</td>
                    <td>{{ $repair->request_repair_at }}</td>
                    <td>{{ $repair->repair_status_name }}</td> <!-- แสดงชื่อสถานะการซ่อม -->
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repairModal{{ $repair->request_detail_id }}">เเก้ไขรายละเอียด</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for showing repair details -->
    @foreach ($repairs as $repair)
        <div class="modal fade" id="repairModal{{ $repair->request_detail_id }}" tabindex="-1" aria-labelledby="repairModalLabel{{ $repair->request_detail_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repairModalLabel{{ $repair->request_detail_id }}">รายละเอียดการแจ้งซ่อม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('updateRepairStatus', $repair->request_detail_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="order{{ $repair->request_detail_id }}" class="form-label">ลำดับ</label>
                                <input type="text" class="form-control" id="order{{ $repair->request_detail_id }}" value="{{ $repair->request_detail_id }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="assetName{{ $repair->request_detail_id }}" class="form-label">ชื่อหรือประเภทของอุปกรณ์</label>
                                <input type="text" class="form-control" id="assetName{{ $repair->request_detail_id }}" value="{{ $repair->asset_name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="assetSymptomDetail{{ $repair->request_detail_id }}" class="form-label">รายละเอียดอาการเสีย</label>
                                <input type="text" class="form-control" id="assetSymptomDetail{{ $repair->request_detail_id }}" value="{{ $repair->asset_symptom_detail }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="location{{ $repair->request_detail_id }}" class="form-label">สถานที่</label>
                                <input type="text" class="form-control" id="location{{ $repair->request_detail_id }}" value="{{ $repair->location }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="assetNumber{{ $repair->request_detail_id }}" class="form-label">หมายเลขครุภัณฑ์</label>
                                <input type="text" class="form-control" id="assetNumber{{ $repair->request_detail_id }}" value="{{ $repair->asset_number }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="repairnote{{ $repair->request_detail_id }}" class="form-label">บันทึกการซ่อม</label>
                                <input type="text" class="form-control" id="repairnote{{ $repair->request_detail_id }}" value="{{ $repair->request_repair_note }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="time{{ $repair->request_repair_at }}" class="form-label">วันที่แจ้งซ่อม</label>
                                <input type="text" class="form-control" id="time{{ $repair->request_repair_at }}" value="{{ $repair->request_repair_at }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="repairStatus{{ $repair->request_detail_id }}" class="form-label">สถานะการซ่อม</label>
                                <select class="form-select" id="repairStatus{{ $repair->request_detail_id }}" name="repair_status_id">
                                    <option value="1" {{ $repair->repair_status_id == 1 ? 'selected' : '' }}>รอดำเนินการ</option>
                                    <option value="2" {{ $repair->repair_status_id == 2 ? 'selected' : '' }}>กำลังดำเนินการ</option>
                                    <option value="3" {{ $repair->repair_status_id == 3 ? 'selected' : '' }}>รออะไหล่</option>
                                    <option value="4" {{ $repair->repair_status_id == 4 ? 'selected' : '' }}>ดำเนินการเสร็จสิ้น</option>
                                    <option value="5" {{ $repair->repair_status_id == 5 ? 'selected' : '' }}>ยกเลิก</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Include DataTables JS and CSS -->
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <style>
        .dataTables_filter {
            float: left !important;
            margin-right: 10px !important; /* Add margin to the right for spacing */
        }

    </style>

    <script>
        $(document).ready(function() {
            $('#repairTable').DataTable({
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
@endsection
