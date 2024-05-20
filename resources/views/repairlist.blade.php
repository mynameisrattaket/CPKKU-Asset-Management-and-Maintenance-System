@extends('layoutmenu')

@section('title', 'รายการแจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">รายการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <div class="col-3 text-end mb-2 mt-2"></div>
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
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repairModal{{ $repair->request_detail_id }}">ดูรายละเอียด</button>
                    </td>
                </tr>

                <!-- Modal for showing repair details -->
                <div class="modal fade" id="repairModal{{ $repair->request_detail_id }}" tabindex="-1" aria-labelledby="repairModalLabel{{ $repair->request_detail_id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="repairModalLabel{{ $repair->request_detail_id }}">รายละเอียดการแจ้งซ่อม</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="order{{ $repair->request_detail_id }}" class="form-label">ID</label>
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
                                        <label for="requestTime{{ $repair->request_detail_id }}" class="form-label">วันเวลาที่เเจ้ง</label>
                                        <input type="text" class="form-control" id="requestTime{{ $repair->request_detail_id }}" value="{{ $repair->request_time }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="requestUserId{{ $repair->request_detail_id }}" class="form-label">ชื่อผู้แจ้ง</label>
                                        <input type="text" class="form-control" id="requestUserId{{ $repair->request_detail_id }}" value="{{ $repair->request_user_id }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="requestUserTypeId{{ $repair->request_detail_id }}" class="form-label">สถานะผู้แจ้ง</label>
                                        <input type="text" class="form-control" id="requestUserTypeId{{ $repair->request_detail_id }}" value="{{ $repair->request_user_type_id }}" readonly>
                                    </div>
                                </form>
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
