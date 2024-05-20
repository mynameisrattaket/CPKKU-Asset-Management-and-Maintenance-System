@extends('layoutmenu')

@section('title', 'รายการแจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">รายการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <div class="col-3 text-end mb-2 mt-2">
    </div>
    <table id="repairTable" class="table table-centered mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ชื่อหรือประเภทของอุปกรณ์</th>
                <th scope="col">รายละเอียดอาการเสีย</th>
                <th scope="col">สถานที่</th>
                <th scope="col">หมายเลขครุภัณฑ์</th>
                <th scope="col">วันเวลาที่เเจ้ง</th>
                <th scope="col">รายละเอียดเพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request as $repair)
                <tr>
                    <th scope="row">{{ $repair->request_detail_id }}</th>
                    <td>{{ $repair->asset_name }}</td>
                    <td>{{ $repair->asset_symptom_detail }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>{{ $repair->asset_number }}</td>
                    <td>{{ $repair->request_time }}</td>
                    <td><button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#repairModal{{ $repair->request_detail_id }}">ดูรายละเอียด</button></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="repairModal{{ $repair->request_detail_id }}" tabindex="-1" aria-labelledby="repairModalLabel{{ $repair->request_detail_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="repairModalLabel{{ $repair->request_detail_id }}">รายละเอียดการแจ้งซ่อม</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>ชื่อหรือประเภทของอุปกรณ์:</strong> {{ $repair->asset_name }}</p>
                                <p><strong>รายละเอียดอาการเสีย:</strong> {{ $repair->asset_symptom_detail }}</p>
                                <p><strong>สถานที่:</strong> {{ $repair->location }}</p>
                                <p><strong>หมายเลขครุภัณฑ์:</strong> {{ $repair->asset_number }}</p>
                                <p><strong>วันเวลาที่เเจ้ง:</strong> {{ $repair->request_time }}</p>
                                <p><strong>ชื่อผู้แจ้ง:</strong> {{ $repair->request_user_id }}</p>
                                <p><strong>สถานะผู้แจ้ง:</strong> {{ $repair->request_user_type_id }}</p>
                                <!-- Add more details here if needed -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('#repairTable').DataTable();
        });
    </script>
@endsection

